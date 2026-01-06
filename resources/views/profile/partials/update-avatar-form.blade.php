<p class="text-muted small">
    Upload foto profil (JPG, PNG, WebP • max 2MB)
</p>

<form method="POST"
      action="{{ route('profile.avatar.update') }}"
      enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="mb-3">
        <img id="avatar-preview"
             src="{{ $user->avatar
                    ? asset('storage/'.$user->avatar)
                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
             class="rounded-circle mb-2"
             width="120"
             height="120">
    </div>

    <input type="file"
           name="avatar"
           class="form-control mb-2 @error('avatar') is-invalid @enderror"
           accept="image/*"
           onchange="previewAvatar(event)">

    @error('avatar')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <button class="btn btn-primary">
        Simpan Foto Profil
    </button>
</form>

@if ($user->avatar)
<form method="POST"
      action="{{ route('profile.avatar.delete') }}"
      class="mt-2">
    @csrf
    @method('DELETE')

    <button class="btn btn-outline-danger btn-sm">
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
