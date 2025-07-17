<div class="mb-3">
    <label for="invited_emails">Запросити користувачів (Email-адреси через кому)</label>
    <textarea name="invited_emails" id="invited_emails" class="form-control" rows="3"
              placeholder="user1@example.com, user2@example.com">{{ old('invited_emails') }}</textarea>

    @error('invited_emails')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
