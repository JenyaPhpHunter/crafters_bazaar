{{--<div class="product-meta mt-5">--}}
{{--    <table>--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <td class="label"><span>Теги</span></td>--}}
{{--            <td class="value">--}}
{{--                <ul class="product-tags">--}}
{{--                    <li><a href="#">handmade</a></li>--}}
{{--                    <li><a href="#">crafters</a></li>--}}
{{--                    <li><a href="#">виріб</a></li>--}}
{{--                </ul>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td class="label"><span>Поширити</span></td>--}}
{{--            <td class="va">--}}
{{--                <div class="product-share">--}}
{{--                    <a href="#"><i class="fab fa-facebook-f" style="color: #72A499;"></i></a>--}}
{{--                    <a href="#"><i class="fab fa-twitter" style="color: #72A499;"></i></a>--}}
{{--                    <a href="#"><i class="fab fa-pinterest" style="color: #72A499;"></i></a>--}}
{{--                    <a href="#"><i class="fal fa-envelope" style="color: #72A499;"></i></a>--}}
{{--                </div>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}
<div class="form-section">
    <label for="tags" class="form-label">Теги (через кому)</label>
    <input type="text" id="tags" name="tags" class="form-control" value="{{ old('tags') }}">
</div>

<div class="form-section">
    <label for="social_links" class="form-label">Посилання на соцмережі</label>
    <input type="text" id="social_links" name="social_links" class="form-control" placeholder="Instagram, TikTok тощо"
           value="{{ old('social_links') }}">
</div>
