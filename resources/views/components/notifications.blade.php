<!-- Toast Notifications Container -->
<div
    class="fixed top-4 right-4 z-50 space-y-3"
    aria-live="assertive"
    aria-atomic="true"
>
    @if(session('success'))
        <x-toast type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-toast type="error" :message="session('error')" />
    @endif

    @if(session('warning'))
        <x-toast type="warning" :message="session('warning')" />
    @endif

    @if(session('info'))
        <x-toast type="info" :message="session('info')" />
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <x-toast type="error" :message="$error" />
        @endforeach
    @endif
</div>
