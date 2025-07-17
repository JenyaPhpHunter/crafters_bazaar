<div class="form-group mb-3">
    <label for="rating">Користувачі бренду</label>

    <div class="form-control bg-light" readonly style="border: 1px solid #ced4da;">
        @foreach($brand->users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $user->name }} ({{ $user->email }})

                @if(auth()->id() === $brand->creator_id && $user->id !== $brand->creator_id)
                    <button type="button"
                            class="btn btn-sm btn-outline-danger"
                            onclick="submitRemoveUser({{ $user->id }})">
                        Видалити
                    </button>
                @endif
            </li>
        @endforeach

        @foreach($brand->invitations as $invitation)
            @php
                $joinedUser = $brand->users->firstWhere('email', $invitation->email);
                $joinedAt = $joinedUser?->pivot?->created_at;
            @endphp

            @if(auth()->id() === $brand->creator_id)
                <li class="d-flex justify-content-between align-items-center">
                    <div>
                        @isset($joinedUser)
                            {{ $joinedUser->name }} -
                        @endisset
                        {{ $invitation->email }}
                        @if($invitation->accepted_at)
                            <span class="text-success">
                                (користувач прийняв запрошення
                                @if($joinedAt)
                                    — приєднався: {{ $joinedAt->format('d.m.Y H:i') }}
                                @endif
                                )
                            </span>
                        @else
                            <span class="text-muted">(очікує)</span>
                            @if($invitation->resent_count > 0)
                                <span class="badge bg-warning text-dark">повторно: {{ $invitation->resent_count }} раз(ів)</span>
                            @endif
                            <span class="text-secondary ms-2">останнє запрошення: {{ $invitation->last_sent_at?->format('d.m.Y H:i') }}</span>
                        @endif
                    </div>

                    @if(is_null($invitation->accepted_at) && auth()->id() === $brand->creator_id)
                        <button type="button"
                                class="btn btn-sm btn-outline-danger ms-2"
                                onclick="submitCancelInvitation({{ $invitation->id }})">
                            Скасувати
                        </button>
                    @endif
                </li>
            @endif
        @endforeach
    </div>
</div>
