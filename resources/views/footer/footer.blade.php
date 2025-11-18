<footer class="bg-neutral-primary-soft">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <div class="col-span-full lg:col-span-1">
                    <img class="h-24 block dark:hidden" src="{{asset('images/su_logo.png')}}"  alt="Stockholms universitet">
                    <img class="h-24 hidden dark:block" src="{{asset('images/su_logo_dark.png')}}"  alt="Stockholms universitet">
                    <p class="mt-3 dark:ml-3 text-xs sm:text-sm text-gray-600 dark:text-gray-200">{{__("Department of Computer and Systems Sciences")}}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h4 class="font-semibold text-gray-900 uppercase dark:text-gray-100">{{__("Stockholm University, DSV")}}</h4>
                    <ul class="mt-3 text-body text-sm">
                        <li>
                            <p class="dark:text-gray-300 dark:hover:text-gray-200">{{__("Postbox 7003, SE-164 07 Kista, Sweden")}}</p>
                        </li>
                        <li>
                            <p class="mb-4 dark:text-gray-300 dark:hover:text-gray-200">{{__("Phone: +46 8 16 20 20")}}</p>
                        </li>
                    </ul>
                </div>
                <div class="md:col-start-3">
                    <div class="hidden md:block">
                        <h4 class="font-semibold text-gray-900 uppercase dark:text-gray-100">{{__("DSV Shortcuts")}}</h4>

                        <div class="mt-3 grid space-y-2 text-sm">
                            <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-200" href="https://nextilearn.dsv.su.se">NextiLearn</a></p>
                            <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-200" href="https://daisy.dsv.su.se">Daisy</a></p>
                            <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-200" href="https://scipro.dsv.su.se">SciPro</a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <hr class="my-6 border-susecondary sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-body sm:text-center"></span>

            <div class="flex items-center mt-4 gap-5 sm:justify-center sm:mt-0">
                <!-- Facebook -->
                <a href="https://www.facebook.com/stockholmuniversity"
                   class="inline-flex items-center text-body hover:text-heading focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-heading dark:text-gray-300 dark:hover:text-gray-200">
                    <span class="sr-only">Facebook page</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                              d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>

                <!-- Twitter / X -->
                <a href="https://twitter.com/stockholms_univ"
                   class="inline-flex items-center text-body hover:text-heading focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-heading dark:text-gray-300 dark:hover:text-gray-200">
                    <span class="sr-only">Twitter page</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13.795 10.533 20.68 2h-3.073l-5.255 6.517L7.69 2H1l7.806 10.91L1.47 22h3.074l5.705-7.07L15.31 22H22l-8.205-11.467Zm-2.38 2.95L9.97 11.464 4.36 3.627h2.31l4.528 6.317 1.443 2.02 6.018 8.409h-2.31l-4.934-6.89Z"/>
                    </svg>
                </a>

                <!-- Instagram -->
                <a href="https://www.instagram.com/stockholmuniversity"
                   class="inline-flex items-center text-body hover:text-heading focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-heading dark:text-gray-300 dark:hover:text-gray-200">
                    <span class="sr-only">Instagram page</span>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                         fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.9.3 2.4.6.6.3 1 .7 1.4 1.4.3.5.5 1.2.6 2.4.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.9-.6 2.4-.3.6-.7 1-1.4 1.4-.5.3-1.2.5-2.4.6-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.9-.3-2.4-.6-.6-.3-1-.7-1.4-1.4-.3-.5-.5-1.2-.6-2.4-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c.1-1.2.3-1.9.6-2.4.3-.6.7-1 1.4-1.4.5-.3 1.2-.5 2.4-.6C8.4 2.2 8.8 2.2 12 2.2Zm0 1.8c-3.1 0-3.4 0-4.6.1-.9.1-1.4.2-1.7.4-.4.2-.6.4-.8.8-.2.3-.3.8-.4 1.7-.1 1.2-.1 1.5-.1 4.6s0 3.4.1 4.6c.1.9.2 1.4.4 1.7.2.4.4.6.8.8.3.2.8.3 1.7.4 1.2.1 1.5.1 4.6.1s3.4 0 4.6-.1c.9-.1 1.4-.2 1.7-.4.4-.2.6-.4.8-.8.2-.3.3-.8.4-1.7.1-1.2.1-1.5.1-4.6s0-3.4-.1-4.6c-.1-.9-.2-1.4-.4-1.7-.2-.4-.4-.6-.8-.8-.3-.2-.8-.3-1.7-.4-1.2-.1-1.5-.1-4.6-.1ZM12 6.9A5.1 5.1 0 1 1 6.9 12 5.1 5.1 0 0 1 12 6.9Zm0 8.4A3.3 3.3 0 1 0 8.7 12 3.3 3.3 0 0 0 12 15.3Zm4.3-8.8a1.2 1.2 0 1 1-1.2-1.2 1.2 1.2 0 0 1 1.2 1.2Z"/>
                    </svg>
                </a>

                <!-- YouTube -->
                <a href="https://www.youtube.com/user/stockholmuniversity"
                   class="inline-flex items-center text-body hover:text-heading focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-heading dark:text-gray-300 dark:hover:text-gray-200">
                    <span class="sr-only">YouTube page</span>
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.5 6.2c-.3-1.2-1.3-2.2-2.5-2.5C18.7 3.3 12 3.3 12 3.3s-6.7 0-9 .4c-1.2.3-2.2 1.3-2.5 2.5C0 8.4 0 12 0 12s0 3.6.5 5.8c.3 1.2 1.3 2.2 2.5 2.5 2.3.3 9 .3 9 .3s6.7 0 9-.3c1.2-.3 2.2-1.3 2.5-2.5.5-2.2.5-5.8.5-5.8s0-3.6-.5-5.8ZM9.7 15.6V8.4l6.2 3.6-6.2 3.6Z"/>
                    </svg>
                </a>

                <!-- LinkedIn -->
                <a href="https://www.linkedin.com/school/stockholm-university/"
                   class="inline-flex items-center text-body hover:text-heading focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-heading dark:text-gray-300 dark:hover:text-gray-200">
                    <span class="sr-only">LinkedIn page</span>
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.45 20.45h-3.6v-5.6c0-1.34-.03-3.07-1.87-3.07-1.87 0-2.16 1.46-2.16 2.97v5.7h-3.6V9h3.46v1.56h.05c.48-.9 1.66-1.85 3.42-1.85 3.66 0 4.34 2.41 4.34 5.54v6.2ZM5.34 7.43a2.08 2.08 0 1 1 0-4.16 2.08 2.08 0 0 1 0 4.16Zm-1.8 13.02h3.6V9h-3.6v11.45ZM22.23 0H1.77A1.77 1.77 0 0 0 0 1.77v20.46C0 23 1 24 1.77 24h20.46A1.77 1.77 0 0 0 24 22.23V1.77A1.77 1.77 0 0 0 22.23 0Z"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</footer>
