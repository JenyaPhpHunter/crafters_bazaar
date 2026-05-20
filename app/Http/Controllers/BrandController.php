<?php

namespace App\Http\Controllers;

use App\Exceptions\BrandCreationException;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\BrandInvitation;
use App\Models\User;
use App\Services\BrandService;
use App\Services\BrandImageService;
use App\Services\BrandInvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    public function __construct(
        protected BrandInvitationService $invitationService,
    ) {}

    public function index(Request $request)
    {
        try {
            $brands = BrandService::getFilteredBrands($request);
            return view('brands.index', $brands);
        } catch (\Exception $e) {
            Log::error('Помилка при отриманні списку брендів', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            return redirect()->route('dashboard')->with('error', 'Сталася помилка при завантаженні списку брендів');
        }
    }

    public function create()
    {
        return view('brands.form', [
            'brand' => null,
            'action' => route('brands.store'),
            'method' => 'POST',
        ]);
    }

    public function store(BrandRequest $request)
    {
        try {
            $data = $request->validated();
            $data['image_path'] = BrandImageService::handle($request->file('image'));

            $brand = BrandService::createBrand($data);
            $this->invitationService->processInvitations($request->input('invited_emails'), $brand);

            return redirect()->route('brands.index')->with('success', 'Бренд успішно створено!');
        } catch (BrandCreationException $e) {
            Log::error('Brand creation failed', [
                'error'   => $e->getMessage(),
                'data'    => $request->except('_token'),
                'user_id' => auth()->id(),
            ]);
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Brand $brand)
    {
        if ($brand->trashed()) {
            return redirect()->route('brands.index')->with('error', 'Цей бренд вже видалено.');
        }

        $brand->load([
            'users' => fn($q) => $q->select('users.id', 'users.name', 'users.email'),
            'creator',
            'invitations',
        ]);

        $isInvited = false;

        if (auth()->check()) {
            $user  = auth()->user();
            $email = $user->email;

            $isInvited = $brand->invitations->contains(
                    fn($inv) => strcasecmp($inv->email, $email) === 0 && is_null($inv->accepted_at)
                ) && !$brand->users->contains($user->id);
        }

        return view('brands.show', compact('brand', 'isInvited'));
    }

    public function edit(Brand $brand)
    {
        $this->authorize('update', $brand);

        try {
            $brand->load(['creator', 'invitations', 'users']);
            return view('brands.form', [
                'brand' => $brand,
                'action' => route('brands.update', $brand),
                'method' => 'PUT',
            ]);
        } catch (\Exception $e) {
            Log::error('Помилка при редагуванні бренду', [
                'brand_id' => $brand->id,
                'error'    => $e->getMessage(),
            ]);
            return redirect()->route('brands.show', $brand)->with('error', 'Не вдалося завантажити форму редагування');
        }
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        try {
            $validated = BrandImageService::processForUpdate($request, $brand);
            BrandService::updateBrand($brand, $validated);
            $this->invitationService->processInvitations($request->input('invited_emails'), $brand);

            return redirect()->route('brands.show', $brand)->with('success', 'Бренд успішно оновлено!');
        } catch (\Exception $e) {
            Log::error('Brand update failed', [
                'brand_id' => $brand->id,
                'error'    => $e->getMessage(),
            ]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            BrandImageService::delete($brand);
            $brand->delete();
            // TODO: видаляти цей бренд з усіх товарів, які в продажу
            return redirect()->route('brands.index')->with('success', 'Бренд успішно видалено!');
        } catch (\Exception $e) {
            Log::error('Brand deletion failed', [
                'brand_id' => $brand->id,
                'error'    => $e->getMessage(),
            ]);
            return redirect()->route('brands.index')->with('error', 'Помилка при видаленні бренду');
        }
    }

    public function restore(Brand $brand)
    {
        $this->authorize('delete', $brand);
        $brand->restore();
        return redirect()->route('brands.index')->with('success', 'Бренд успішно відновлено!');
    }

    public function invite(Request $request, Brand $brand)
    {
        $this->authorize('update', $brand);

        try {
            $this->invitationService->processInvitations($request->input('invited_emails'), $brand);
        } catch (\Throwable $e) {
            Log::error('Помилка при відправці запрошень', ['error' => $e->getMessage()]);
            return redirect()->route('brands.show', $brand)->with('error', 'Не вдалося надіслати запрошення.');
        }

        return redirect()->route('brands.show', $brand)->with('success', 'Запрошення надіслано.');
    }

    public function acceptInvitation(Request $request, Brand $brand)
    {
        return $this->invitationService->acceptInvitation($request, $brand);
    }

    public function join(Brand $brand)
    {
        return $this->invitationService->join($brand);
    }

    public function leave(Brand $brand)
    {
        // TODO: видаляти цей бренд з усіх товарів, які в продажу цього користувача
        return $this->invitationService->leave($brand);
    }

    public function removeUser(Brand $brand, User $user)
    {
        // TODO: видаляти цей бренд з усіх товарів, які в продажу цього користувача
        $this->authorize('update', $brand);

        if ($user->id === $brand->creator_id) {
            return redirect()->back()->with('error', 'Ви не можете видалити себе як автора бренду.');
        }

        $this->invitationService->removeUserFromBrand($brand, $user);

        return redirect()->back()->with('success', 'Користувача та його запрошення видалено з бренду.');
    }

    public function cancelInvitation(Brand $brand, BrandInvitation $invitation)
    {
        $this->authorize('update', $brand);

        if ($invitation->accepted_at !== null) {
            return redirect()->back()->with('error', 'Запрошення вже прийнято і не може бути скасоване.');
        }

        $this->invitationService->cancelInvitation($brand, $invitation);

        return redirect()->back()->with('success', 'Запрошення скасовано.');
    }
}
