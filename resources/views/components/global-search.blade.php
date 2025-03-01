<div x-cloak="true"
    x-data="{
    query: '',
    loading: false,
    results: { guardians: [], patients: [] },
    searched: false,

    resetSearch() {
        this.query = '';
        this.results = {};
    },

    async search() {
        if (this.query.length < 2) {
            this.results = { guardians: [], patients: [] };
            return;
        }

        this.loading = true;

        try {
            const url = new URL(@js(route('global.search')));
            url.searchParams.set('keyword', this.query);
            const response = await fetch(url);
            this.results = await response.json();
        } catch (error) {
            console.error('Search Error:', error);
        }

        this.loading = false;
        this.searched = true;
    }
}" @click.away="resetSearch()" @keydown.escape.window="resetSearch()">
    <div class="position-relative">
        <!-- Search Input -->
        <div class="input-group" style="border: 1px solid black; border-radius:5px;">
            <span class="input-group-text p-1">
                <i class="fa fa-search"></i>
            </span>

            <input type="text" class="form-control" placeholder="Search..." x-model="query"
                @input.debounce.500ms="search()" style="width: 300px;" autocomplete="off" />

        </div>
        <!-- Search Results Dropdown -->
        <div x-show="query.length > 2" x-transition class="dropdown-menu show w-100 position-absolute mt-1"
            style="z-index: 1050; max-height: 300px; min-height:40px; overflow-y: auto; overflow-x: hidden; background: white; border: 1px solid #ddd;">

            <div class="row d-flex justify-content-center align-items-center">

                <div class="col-10">
                    <div class="loader" x-show="loading"></div>
                </div>

                <div class="col-2 text-end">
                    <button type="button" class="btn-close" x-on:click="resetSearch()" style="z-index: 1051;"></button>
                </div>
            </div>


            <template x-if="results.guardians?.length">
                <div>
                    <h6 class="dropdown-header">GUARDIANS</h6>

                    <template x-for="guardian in results.guardians" :key="guardian.id">
                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                            <a :href="'/guardians/' + guardian.id" class="text-decoration-none">
                                <span
                                    x-text="(guardian.fullname.first_name ?? '') + ' ' + (guardian.fullname.middle_name ?? '') + ' ' + (guardian.fullname.last_name ?? '')"></span>
                            </a>
                        </div>
                    </template>
                </div>
            </template>

            <template x-if="results.patients?.length">
                <div>
                    <h6 class="dropdown-header">PATIENTS</h6>

                    @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 5)
                        <template x-for="patient in results.patients" :key="patient.id">
                            <div class="dropdown-item d-flex justify-content-between align-items-center">
                                <a :href="'/patientEncounterSummary/' + patient.registration_number" class="text-decoration-none">
                                <span
                                    x-text="(patient.fullname.first_name ?? '') + ' ' + (patient.fullname.middle_name ?? '') + ' ' + (patient.fullname.last_name ?? '')"></span>
                                </a>
                            </div>
                        </template>
                    @else
                        <template x-for="patient in results.patients" :key="patient.id">
                            <div class="dropdown-item d-flex justify-content-between align-items-center">
                                <a :href="'/patients/' + patient.id" class="text-decoration-none">
                                <span
                                    x-text="(patient.fullname.first_name ?? '') + ' ' + (patient.fullname.middle_name ?? '') + ' ' + (patient.fullname.last_name ?? '')"></span>
                                </a>


                                <a :href="'/visithandle/' + patient.id">
                                    <button class="btn btn-dark btn-sm">Visit</button>
                                </a>
                            </div>
                        </template>
                    @endif
                </div>
            </template>

            <template x-if="results.guardians?.length == 0 && results.patients?.length == 0 && loading == false && searched == true">
                <div class="dropdown-item">
                    <span class="text-red-500">Whoops! <strong x-text="query"></strong> not found.</span>
                </div>
            </template>
        </div>
    </div>

    <style>
        .loader {
            height: 5px;
            width: 100%;
            --c: no-repeat linear-gradient(#6100ee 0 0);
            background: var(--c), var(--c), #d7b8fc;
            background-size: 60% 100%;
            animation: l16 3s infinite;
            border-radius: 5px;
        }

        @keyframes l16 {
            0% {
                background-position: -150% 0, -150% 0
            }

            66% {
                background-position: 250% 0, -150% 0
            }

            100% {
                background-position: 250% 0, 250% 0
            }
        }
    </style>
</div>
