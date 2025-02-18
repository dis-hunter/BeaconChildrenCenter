<div>
    {{-- Stop trying to control. --}}
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex justify-content-start align-items-center">
                <div class="col-md-8 col-sm-8">
                    <div class="form-floating mb-4">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" wire:model="password" required autocomplete="new-password"/>
                        <i class="bi bi-eye-slash" id="togglePassword" style="transform: scale(1.2);"></i>
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-4">
                    <button
                        type="button"
                        x-data="{ loading: false }"
                        x-on:click="loading = true; $wire.generatePassword().then(() => { loading = false })"
                        :disabled="loading"
                        class="ml-4 inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-white hover:bg-grey-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <svg
                            x-show="loading"
                            class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>

                        <span x-text="'Generate'"></span>
                    </button>
                    {{-- <button class="btn btn-dark w-100" style="padding:10px;" type="button" wire:click="generatePassword">Generate</button> --}}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <link rel="stylesheet" href="{{asset('css/style.css')}}">
            <label for="password-meter">Password Strength</label>
            <div class="password-meter">
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded"></div>
            </div>
            <div id="passwordHelp" class="form-text text-muted mb-4">Use 8 or more characters with a mix of
                letters, numbers &
                symbols.
            </div>
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-6">
            <div class="form-floating mb-4">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" wire:model="confirmpassword" required autocomplete="off" />
                <i class="bi bi-eye-slash" id="togglePassword2" style="transform: scale(1.2);"></i>
                <label for="password_confirmation">Confirm Password</label>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
    
</div>


