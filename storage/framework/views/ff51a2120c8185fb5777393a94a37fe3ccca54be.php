<div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-md-8">
                    <div class="form-floating mb-4">
                        <input type="password" id="password-input" name="password" class="form-control" placeholder="Password" wire:model="password" required />
                        <i class="bi bi-eye-slash" id="togglePassword" style="transform: scale(1.2);"></i>
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <button class="btn btn-dark w-100" style="padding:10px;" type="button" wire:click="generatePassword">Generate</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
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
                <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm Password" wire:model="confirmpassword" required />
                <i class="bi bi-eye-slash" id="togglePassword2" style="transform: scale(1.2);"></i>
                <label for="confirmpassword">Confirm Password</label>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>

<?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/livewire/password-generator.blade.php ENDPATH**/ ?>