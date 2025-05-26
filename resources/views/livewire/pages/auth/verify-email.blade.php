<div class="min-h-screen bg-slate-300 flex items-end pd-10">
    <div class=" w-full max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class=" text-2xl font-bold mb-6 text-center" >
            {{ app()->getLocale() == 'ha' ? 'Tabbater da Imel' : 'Verify Your Email' }}
        </h2>
    <!-- Messages -->
     @if (session('message'))
        <div class=" mb-4 p-2 bg-green-200 text-green-700 rounded">
            {{ session('message') }}
        </div> 
     @endif
    <!-- Messages -->
     @if (session('error'))
        <div class=" mb-4 p-2 bg-green-200 text-green-700 rounded">
            {{ session('error') }}
        </div> 
     @endif
    <p class=" mb-4">
        {{ app()->getLocale() == 'ha' ? 'An aiko da hanyar tabbatarwa zuwa adreshin imel qin ko.' : 'A verification link has been send to your email address.' }}
    </p>
    <form method="post" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class=" w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-700">
            {{ app()->getLocale() == 'ha' ? 'Sake Aiko da Imel' : 'Resend Email' }}
        </button>
    </form>
    <div class=" mt-2 text-center">
        <a href="{{ route('logout') }}" class=" text-blue-500 hover:underline">
            {{ app()->getLocale() == 'ha' ? 'Fita' : 'Logout' }}
        </a>
    </div>
</div>
    </div>