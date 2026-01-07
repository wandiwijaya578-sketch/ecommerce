<p class="text-muted small">
    Upload foto profil (JPG, PNG, WebP • max 2MB)
</p>

{{-- Form update avatar --}}
<form method="POST"
      action="{{ route('profile.updateAvatar') }}"
      enctype="multipart/form-data">
    @csrf

    <div class="mb-3 text-center">
        <img id="avatar-preview"
             src="{{ $user->avatar
                    ? asset('storage/'.$user->avatar)
                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
             class="rounded-circle mb-2"
             width="120"
             height="120"
             style="object-fit: cover;">
    </div>

    <input type="file"
           name="avatar"
           class="form-control mb-2 @error('avatar') is-invalid @enderror"
           accept="image/*"
           onchange="previewAvatar(event)">

    @error('avatar')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary w-100">
        Simpan Foto Profil
    </button>
</form>

{{-- Form hapus avatar --}}
@if ($user->avatar)
<form method="POST"
      action="{{ route('profile.deleteAvatar') }}"
      class="mt-2">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-outline-danger w-100">
        Hapus Foto Profil
    </button>
</form>
@endif

<script>
function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('avatar-preview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
