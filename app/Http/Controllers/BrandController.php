<?php

namespace App\Http\Controllers;

use App\Constants\ProductsConstants;
use App\Exceptions\BrandCreationException;
use App\Http\Requests\BrandRequest;
use App\Mail\InviteToBrandMail;
use App\Models\Brand;
use App\Models\ForumCategory;
use App\Models\ForumSubCategory;
use App\Models\ForumTopic;
use App\Models\User;
use App\Services\BrandService;
use App\Services\EmailService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the brands.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            // Отримуємо параметри фільтрації з запиту
            $search = $request->input('search');
            $sortField = $request->input('sort_by', 'created_at');
            $sortDirection = $request->input('sort_dir', 'desc');
            $perPage = $request->input('per_page', 10);
            $ratingFilter = $request->input('rating');

            // Базовий запит з відношеннями
            $query = Brand::with(['users:id,name'])
                ->withCount('users');

            // Застосовуємо пошук
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            }

            // Фільтр по рейтингу
            if ($ratingFilter) {
                $query->where('rating', $ratingFilter);
            }

            // Сортування
            $validSortFields = ['title', 'created_at', 'updated_at', 'rating', 'users_count'];
            $sortField = in_array($sortField, $validSortFields) ? $sortField : 'created_at';
            $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc';

            $query->orderBy($sortField, $sortDirection);

            // Пагінація
            $brands = $query->paginate($perPage)
                ->appends($request->query());

            // Отримуємо доступні рейтинги для фільтра
            $availableRatings = config('others.rating');

            return view('brands.index', [
                'brands' => $brands,
                'search' => $search,
                'sortField' => $sortField,
                'sortDirection' => $sortDirection,
                'perPage' => $perPage,
                'ratingFilter' => $ratingFilter,
                'availableRatings' => $availableRatings,
            ]);

        } catch (\Exception $e) {
            Log::error('Помилка при отриманні списку брендів', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return redirect()
                ->route('dashboard')
                ->with('error', 'Сталася помилка при завантаженні списку брендів');
        }
    }

    /**
     * Показує форму для створення нового бренду.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('brands.create');
    }


    public function store(BrandRequest $request, EmailService $emailService)
    {
        try {
            $data = $request->validated();
            $data['image_path'] = BrandService::handleBrandImage($request->file('image'));

            $brand = BrandService::createBrand($data);

            if (!empty($request->input('invited_emails'))) {
                $emails = explode(',', $request->input('invited_emails'));
                BrandService::inviteUsersToBrand($emails, $brand, $emailService);
            }

            return redirect()->route('brands.index')->with('success', 'Бренд успішно створено!');

        } catch (\Exception $e) {
            Log::error('Brand creation failed', [
                'error' => $e->getMessage(),
                'data' => $request->except('_token')
            ]);

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Показати сторінку одного бренду
     */
    public function show(Brand $brand)
    {
        $availableRatings = config('others.rating');
        return view('brands.show', [
            'brand' => $brand,
            'availableRatings' => $availableRatings
        ]);
    }


    /**
     * Показує форму для редагування бренду.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\View\View
     */
    public function edit(Brand $brand)
    {
        try {
            $users = User::select('id', 'name')->get();

            $ratings = config('others.rating');

            return view('brands.edit', [
                'brand' => $brand,
                'users' => $users,
                'ratings' => $ratings,
                'currentRating' => old('rating', $brand->rating),
            ]);

        } catch (\Exception $e) {
            Log::error('Помилка при відображенні форми редагування бренду', [
                'brand_id' => $brand->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('brands.show', $brand)
                ->with('error', 'Не вдалося завантажити форму редагування');
        }
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        try {
            $validated = $request->validated();

            if ($request->boolean('remove_image') && $brand->image_path) {
                Storage::delete('public/' . $brand->image_path);
                $validated['image_path'] = null;
            }

            if ($request->hasFile('image')) {
                if ($brand->image_path) {
                    Storage::delete('public/' . $brand->image_path);
                }
                $validated['image_path'] = $request->file('image')->store('brands', 'public');
            }

            BrandService::updateBrand($brand, $validated);

            Log::info('Brand updated', ['brand_id' => $brand->id]);

            return redirect()
                ->route('brands.show', $brand)
                ->with('success', 'Бренд успішно оновлено!');

        } catch (\Exception $e) {
            Log::error('Brand update failed', [
                'brand_id' => $brand->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Видалення зображення, якщо є
            if ($brand->image_path) {
                Storage::disk('public')->delete($brand->image_path);
            }

            $brand->delete();

            return redirect()
                ->route('brands.index')
                ->with('success', 'Бренд успішно видалено!');
        } catch (\Exception $e) {
            \Log::error('Brand deletion failed', [
                'brand_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('brands.index')
                ->with('error', 'Помилка при видаленні бренду');
        }
    }
}
