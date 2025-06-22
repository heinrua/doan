
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
    
    <div class = "
        'p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600',
        'before:hidden before:xl:block before:content-[\'\'] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-primary/20 before:rounded-[100%] before:dark:bg-darkmode-400',
        'after:hidden after:xl:block after:content-[\'\'] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform after:rotate-[-4.5deg] after:bg-primary after:rounded-[100%] after:dark:bg-darkmode-700',
    ">
        <div class="container relative z-10 sm:px-10">
            <div class="block grid-cols-2 gap-4 xl:grid">
                <!-- BEGIN: Login Info -->
                <div class="hidden min-h-screen flex-col xl:flex">
                    <div class="my-auto ">
                        <img
                        src="{{ Vite::asset('resources/images/camau.png') }}"
                        alt=" PCTT Cà Mau"
                        style="height: 100%; width:100%;"/>  
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="my-10 flex h-screen py-5 xl:my-0 xl:h-auto xl:py-0">
                    <div
                        class="mx-auto my-auto w-full rounded-md bg-white px-5 py-8 shadow-md dark:bg-darkmode-600 sm:w-3/4 sm:px-8 lg:w-2/4 xl:ml-20 xl:w-auto xl:bg-transparent xl:p-0 xl:shadow-none">
                        <h2 class="intro-x text-center text-2xl font-bold xl:text-left xl:text-3xl">
                            Đăng nhập vào trang chủ
                        </h2>
                        <div class="intro-x mt-2 text-center text-slate-400 xl:hidden">
                            Một vài cú nhấp chuột nữa để đăng nhập vào tài khoản của bạn
                        </div>
                        <form class="validate-form" action="/login" method="post">
                            @csrf
                            <div class="intro-x mt-6">
                                <div class="input-form mt-3">
                                    <label for="user_name" class="inline-block text-sm/6 font-medium text-gray-900 ">Tên đăng nhập</label>
                                    <div class="mt-2">
                                    <input id="validation-form-2" name="user_name" id="user_name" type="text" placeholder="Tên Đăng Nhập" required="required" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                    
                                   
                                </div>
                                <div class="input-form mt-3">
                                    <div class="flex items-center justify-between">
                                        <label for="validation-form-3" class="block text-sm/6 font-medium text-gray-900">Mật khẩu</label>
                                        <div class="text-sm">
                                            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Quên mật khẩu?</a>
                                        </div>
                                        </div>
                                        <div class="mt-2">
                                        <input type="password" id="password" name="password" id="validation-form-3" minlength="8" required="required" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                    
                                
                                </div>
                            </div>
                            <div class="intro-x mt-5 text-center xl:mt-8 xl:text-left">
                                <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Đăng nhập
                                </button>
                                
                            </div>
                            
</body>

                        </form>
                        
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
    </div>
    
</body>
</html>
    
