<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo" x-on:change="
                                                        photoName = $refs.photo.files[0].name;
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            photoPreview = e.target.result;
                                                        };
                                                        reader.readAsDataURL($refs.photo.files[0]);
                                                " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full size-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required
                autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required
                autocomplete="username" />
            <x-input-error for="email" class="mt-2" />
        </div>

        <!-- NIK -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="nik" value="{{ __('NIK') }}" />
            <x-input id="nik" type="text" class="mt-1 block w-full" wire:model="state.nik" />
            <x-input-error for="nik" class="mt-2" />
        </div>

        <!-- Instansi -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="instansi" value="{{ __('Instansi') }}" />
            <x-input id="instansi" type="text" class="mt-1 block w-full" wire:model="state.instansi" />
            <x-input-error for="instansi" class="mt-2" />
        </div>

        <!-- No HP WA -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="no_hp_wa" value="{{ __('No. HP WA') }}" />
            <x-input id="no_hp_wa" type="text" class="mt-1 block w-full" wire:model="state.no_hp_wa" />
            <x-input-error for="no_hp_wa" class="mt-2" />
        </div>

        <!-- Status Pegawai -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="status_pegawai" value="{{ __('Status Pegawai') }}" />
            <select id="status_pegawai"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                wire:model="state.status_pegawai">
                <option value="">-- Pilih Status --</option>
                <option value="PNS">PNS</option>
                <option value="PPPK">PPPK</option>
                <option value="Non ASN">Non ASN</option>
            </select>
            <x-input-error for="status_pegawai" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>