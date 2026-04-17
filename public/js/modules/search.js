(function ($) {
    "use strict";

    const SUGGEST_URL = '/search/suggest';
    const MIN_CHARS   = 2;
    let   debounceTimer = null;

    function buildDropdown(items, $input) {
        let $dropdown = $('#search-suggestions');

        if (!$dropdown.length) {
            $dropdown = $('<ul id="search-suggestions"></ul>').css({
                position:   'absolute',
                background: 'var(--bs-body-bg, #fff)',
                border:     '1px solid #ddd',
                borderTop:  'none',
                listStyle:  'none',
                margin:     0,
                padding:    0,
                zIndex:     9999,
                width:      $input.outerWidth() + 'px',
                maxHeight:  '360px',
                overflowY:  'auto',
                borderRadius: '0 0 6px 6px',
                boxShadow:  '0 4px 12px rgba(0,0,0,.08)',
            });
            $input.after($dropdown);
        }

        $dropdown.empty();

        if (!items.length) {
            $dropdown.append(
                $('<li>').css({ padding: '10px 16px', color: '#999', fontSize: '13px' })
                    .text('Нічого не знайдено')
            );
        } else {
            items.forEach(item => {
                const $li = $('<li>').css({ padding: '8px 12px', cursor: 'pointer', display: 'flex', alignItems: 'center', gap: '10px' })
                    .on('mouseenter', function () { $(this).css('background', '#f5f5f5'); })
                    .on('mouseleave', function () { $(this).css('background', ''); })
                    .on('click', function () {
                        window.location.href = item.url;
                    });

                if (item.photo) {
                    $li.append(
                        $('<img>').attr('src', item.photo).css({ width: '40px', height: '40px', objectFit: 'cover', borderRadius: '4px', flexShrink: 0 })
                    );
                }

                const $info = $('<div>').css({ flex: 1, minWidth: 0 });
                $info.append($('<div>').css({ fontWeight: 500, fontSize: '14px', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }).text(item.title));
                $info.append($('<div>').css({ fontSize: '12px', color: '#888' }).text(item.price + ' ₴'));

                $li.append($info);
                $dropdown.append($li);
            });
        }

        positionDropdown($input, $dropdown);
        $dropdown.show();
    }

    function positionDropdown($input, $dropdown) {
        const offset = $input.offset();
        $dropdown.css({
            top:  offset.top + $input.outerHeight() - 1,
            left: offset.left,
        }).detach().appendTo('body');
    }

    function closeDropdown() {
        $('#search-suggestions').remove();
    }

    function doSuggest($input) {
        const q = $input.val().trim();

        if (q.length < MIN_CHARS) {
            closeDropdown();
            return;
        }

        $.get(SUGGEST_URL, { q }, function (data) {
            buildDropdown(data, $input);
        }).fail(function () {
            closeDropdown();
        });
    }

    $(document).ready(function () {
        // Шукаємо поле пошуку в хедері — адаптуй селектор під свій шаблон
        const $searchInput = $('input[name="search"][data-suggest="true"]');

        if (!$searchInput.length) return;

        // Autocomplete: debounce при введенні
        $searchInput.on('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => doSuggest($(this)), 300);
        });

        // Закрити при кліку поза
        $(document).on('click', function (e) {
            if (!$(e.target).closest($searchInput).length && !$(e.target).closest('#search-suggestions').length) {
                closeDropdown();
            }
        });

        // Клавіші: Escape закриває, Enter — повний пошук
        $searchInput.on('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDropdown();
                return;
            }

            // Навігація стрілками
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                const $items = $('#search-suggestions li');
                if (!$items.length) return;

                let $current = $items.filter('.active');
                let idx = $items.index($current);

                if (e.key === 'ArrowDown') {
                    idx = (idx + 1) % $items.length;
                } else {
                    idx = (idx - 1 + $items.length) % $items.length;
                }

                $items.removeClass('active').css('background', '');
                $items.eq(idx).addClass('active').css('background', '#f5f5f5');
            }

            // Enter: якщо є виділений — перейти, інакше — стандартний submit
            if (e.key === 'Enter') {
                const $active = $('#search-suggestions li.active');
                if ($active.length) {
                    e.preventDefault();
                    $active.trigger('click');
                }
                // якщо active немає — форма сабмітиться сама по собі (index з ?search=)
                closeDropdown();
            }
        });

        // Адаптувати ширину при resize
        $(window).on('resize', function () {
            const $dropdown = $('#search-suggestions');
            if ($dropdown.is(':visible')) {
                positionDropdown($searchInput, $dropdown);
                $dropdown.css('width', $searchInput.outerWidth() + 'px');
            }
        });
    });

})(jQuery);
