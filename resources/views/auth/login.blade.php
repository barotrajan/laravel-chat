<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Chat</title>
</head>

<div class="flex h-screen container mx-auto p-20 text-neutral-800 bg-gray-100">
    <section class="py-24">
        <div class="h-full">

            <!-- Left column container with background-->
            <div class="g-6 flex h-full flex-wrap items-center justify-center lg:justify-between">
                <div class="shrink-1 mb-12 grow-0 basis-auto md:mb-0 md:w-9/12 md:shrink-0 lg:w-6/12 xl:w-6/12">
                    <img src="https://tecdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                        class="w-full" alt="Sample image">
                </div>

                <!-- Right column container -->
                <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-5/12">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="flex flex-row items-center justify-center lg:justify-start">
                            <p class="mb-8 mr-4 text-xl text-cyan-600">Sign in to start your session</p>
                        </div>

                        <!-- Email input -->
                        <div class="relative mb-6" data-te-input-wrapper-init="">
                            <input type="texemailt"
                                class="peer block min-h-[auto] w-full rounded border-0 px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-800 dark:placeholder:text-neutral-800 [&amp;:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                id="exampleFormControlInput2" name="email" placeholder="Email address"
                                data-te-input-state-active="">
                            <label for="exampleFormControlInput2"
                                class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-sky-800   peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-800 dark:peer-focus:text-sky-800  "
                                style="margin-left: 0px;">Email address
                            </label>
                            <div class="group flex absolute left-0 top-0 w-full max-w-full h-full text-left pointer-events-none"
                                data-te-input-notch-ref="" data-te-input-state-active="">
                                <div class="pointer-events-none border border-solid box-border transition-all duration-200 ease-linear motion-reduce:transition-none left-0 top-0 h-full w-2 border-r-0 rounded-l-[0.25rem] group-data-[te-input-focused]:border-r-0 group-data-[te-input-state-active]:border-r-0 border-neutral-300 dark:border-neutral-600 group-data-[te-input-focused]:shadow-[-1px_0_0_#3b71ca,_0_1px_0_0_#3b71ca,_0_-1px_0_0_#3b71ca] group-data-[te-input-focused]:border-primary"
                                    data-te-input-notch-leading-ref="" style="width: 9px;"></div>
                                <div class="pointer-events-none border border-solid box-border transition-all duration-200 ease-linear motion-reduce:transition-none grow-0 shrink-0 basis-auto w-auto max-w-[calc(100%-1rem)] h-full border-r-0 border-l-0 group-data-[te-input-focused]:border-x-0 group-data-[te-input-state-active]:border-x-0 group-data-[te-input-focused]:border-t group-data-[te-input-state-active]:border-t group-data-[te-input-focused]:border-solid group-data-[te-input-state-active]:border-solid group-data-[te-input-focused]:border-t-transparent group-data-[te-input-state-active]:border-t-transparent border-neutral-300 dark:border-neutral-600 group-data-[te-input-focused]:shadow-[0_1px_0_0_#3b71ca] group-data-[te-input-focused]:border-primary"
                                    data-te-input-notch-middle-ref="" style="width: 82.8px;"></div>
                                <div class="pointer-events-none border border-solid box-border transition-all duration-200 ease-linear motion-reduce:transition-none grow h-full border-l-0 rounded-r-[0.25rem] group-data-[te-input-focused]:border-l-0 group-data-[te-input-state-active]:border-l-0 border-neutral-300 dark:border-neutral-600 group-data-[te-input-focused]:shadow-[1px_0_0_#3b71ca,_0_-1px_0_0_#3b71ca,_0_1px_0_0_#3b71ca] group-data-[te-input-focused]:border-primary"
                                    data-te-input-notch-trailing-ref=""></div>
                            </div>
                            <span>
                                @if ($errors->has('email'))
                                    <div class="text-rose-700">{{ $errors->first('email') }}</div>
                                @endif
                            </span>
                        </div>

                        <!-- Password input -->
                        <div class="relative mb-6" data-te-input-wrapper-init="">
                            <input type="password"
                                class="peer block min-h-[auto] w-full rounded border-0 px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-800 dark:placeholder:text-neutral-800 [&amp;:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                id="password" placeholder="Password" name="password" data-te-input-state-active="">
                            <label for="password"
                                class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-sky-800 peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-800 dark:peer-focus:text-sky-800"
                                style="margin-left: 0px;">Password
                            </label>
                            <div class="group flex absolute left-0 top-0 w-full max-w-full h-full text-left pointer-events-none"
                                data-te-input-notch-ref="" data-te-input-state-active="">
                                <div class="pointer-events-none border border-solid box-border transition-all duration-200 ease-linear motion-reduce:transition-none left-0 top-0 h-full w-2 border-r-0 rounded-l-[0.25rem] group-data-[te-input-focused]:border-r-0 group-data-[te-input-state-active]:border-r-0 border-neutral-300 dark:border-neutral-600 group-data-[te-input-focused]:shadow-[-1px_0_0_#3b71ca,_0_1px_0_0_#3b71ca,_0_-1px_0_0_#3b71ca] group-data-[te-input-focused]:border-primary"
                                    data-te-input-notch-leading-ref="" style="width: 9px;"></div>
                                <div class="pointer-events-none border border-solid box-border transition-all duration-200 ease-linear motion-reduce:transition-none grow-0 shrink-0 basis-auto w-auto max-w-[calc(100%-1rem)] h-full border-r-0 border-l-0 group-data-[te-input-focused]:border-x-0 group-data-[te-input-state-active]:border-x-0 group-data-[te-input-focused]:border-t group-data-[te-input-state-active]:border-t group-data-[te-input-focused]:border-solid group-data-[te-input-state-active]:border-solid group-data-[te-input-focused]:border-t-transparent group-data-[te-input-state-active]:border-t-transparent border-neutral-300 dark:border-neutral-600 group-data-[te-input-focused]:shadow-[0_1px_0_0_#3b71ca] group-data-[te-input-focused]:border-primary"
                                    data-te-input-notch-middle-ref="" style="width: 62.8px;"></div>
                                <div class="pointer-events-none border border-solid box-border transition-all duration-200 ease-linear motion-reduce:transition-none grow h-full border-l-0 rounded-r-[0.25rem] group-data-[te-input-focused]:border-l-0 group-data-[te-input-state-active]:border-l-0 border-neutral-300 dark:border-neutral-600 group-data-[te-input-focused]:shadow-[1px_0_0_#3b71ca,_0_-1px_0_0_#3b71ca,_0_1px_0_0_#3b71ca] group-data-[te-input-focused]:border-primary"
                                    data-te-input-notch-trailing-ref=""></div>
                            </div>
                        </div>

                        <!-- Login button -->
                        <div class="text-center lg:text-left">
                            <button type="submit"
                                class="inline-block rounded bg-cyan-500 hover:bg-cyan-600 px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                data-te-ripple-init="" data-te-ripple-color="light">
                                Login
                            </button>

                            <!-- Register link -->
                            <p class="mb-0 mt-2 pt-1 text-sm font-semibold">
                                Don't have an account?
                                <a href="#!"
                                    class="text-sky-700 transition duration-150 ease-in-out hover:text-sky-600 focus:text-sky-600 active:text-sky-700">Register</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

</html>
