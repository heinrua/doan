
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    @stack('styles')
    <meta name="author" content="LEFT4CODE">
</head>
<body >
<!-- component -->
<div class="flex h-screen">
   <!-- Left Pane  -->
  <div class="hidden lg:flex items-center justify-center flex-1 bg-white text-black">
    <div class="w-full h-full">
        <img src="{{ asset('images/image.png') }}" alt="Hình ảnh" class="w-full h-full object-cover">
    </div>

  </div>
  <!-- Right Pane -->
  <div class="w-full bg-gray-100 lg:w-1/2 flex items-center justify-center">
    <div class="max-w-md w-full p-6">
      <h1 class="text-3xl font-semibold mb-6 text-black text-center">ĐĂNG NHẬP</h1>
      <h1 class="text-sm font-semibold mb-6 text-gray-500 text-center">Đăng nhập với tài khoản của bạn</h1>
      
      
      <form class="validate-form" action="/login" method="post">
        @csrf
        <div class="intro-x mt-6">
            <div class="input-form mt-3">
                <label for="user_name" class="inline-block text-sm/6 font-medium text-gray-900 ">Tên đăng nhập</label>
                <div class="mt-2">
                <input  name="user_name" id="user_name" type="text" placeholder="Tên Đăng Nhập" required="required" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>
            <div class="input-form mt-3">
                <div class="flex items-center justify-between">
                    <label for="validation-form-3" class="block text-sm/6 font-medium text-gray-900">Mật khẩu</label>
                    <div class="text-sm">
                        <a href="javascript:void(0)" onclick="openForgotPasswordModal()" class="font-semibold text-indigo-600 hover:text-indigo-500">
                            Quên mật khẩu?
                        </a>
                    </div>
                    </div>
                    <div class="mt-2 relative">
                        <input type="password" name="password" id ="password" class="w-full p-3 border border-gray-300 rounded">
                    </div>
                    @if (session('error'))
                        <p class="text-sm text-red-600 mt-2">
                            {{ session('error') }}
                        </p>
                    @endif
            </div>
             @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="intro-x mt-5 text-center xl:mt-8 xl:text-left">
            <button type="submit" class="w-full flex justify-center">
                Đăng nhập
            </button>
            

        </div>

       </form>
      
    </div>
  </div>
</div>


 <!-- Quên mật khẩu -->
<div id="forgot-password-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed inset-0 bg-black/50"></div>
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Nhập tên đăng nhập của bạn
                </h3>
                <button type="button" onclick="closeForgotPasswordModal()" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                    x
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div>
                        <label for="user_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên đăng nhập</label>
                        <input  name="user_name" id="user_name"  required />
                    </div>
                    
                    <button type="submit" class ="m-5">Gửi link khôi phục mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>   
</body>
<script>
    function openForgotPasswordModal() {
        const modal = document.getElementById('forgot-password-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeForgotPasswordModal() {
        const modal = document.getElementById('forgot-password-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>


</html>


