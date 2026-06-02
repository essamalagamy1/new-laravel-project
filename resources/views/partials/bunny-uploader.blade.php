@persist('bunny-uploader-persist')
<div wire:ignore>
    <div x-data="bunnyGlobalUploader()"
         @start-bunny-upload.window="addUpload($event.detail)"
         class="fixed bottom-4 {{app()->getLocale() === 'ar' ? 'right-4' : 'left-4'}} z-[9999] w-80 shadow-2xl rounded-xl overflow-hidden bg-base-100 border border-base-300 transition-all duration-300"
         x-cloak
         x-show="isVisible && uploads.length > 0">

        <!-- Header -->
        <div class="bg-primary text-primary-content p-3 flex justify-between items-center cursor-pointer select-none" @click="isMinimized = !isMinimized">
            <div class="font-bold text-sm flex items-center gap-2">
                <x-icon name="o-cloud-arrow-up" class="w-5 h-5" />
                <span>{{ __('lang.uploads') ?? 'Uploads' }}</span>
                <span class="badge badge-warning badge-sm" x-text="uploads.length"></span>
            </div>
            <div class="flex gap-1">
                <!-- Minimize / Maximize -->
                <button @click.stop="isMinimized = !isMinimized" class="btn btn-ghost btn-xs btn-circle text-primary-content">
                    <x-icon name="o-chevron-up" x-show="isMinimized" class="w-4 h-4" />
                    <x-icon name="o-chevron-down" x-show="!isMinimized" class="w-4 h-4" />
                </button>
                <!-- Close All -->
                <button @click.stop="closeUploader()" class="btn btn-ghost btn-xs btn-circle text-primary-content" title="{{ __('lang.close') ?? 'Close' }}">
                    <x-icon name="o-x-mark" class="w-4 h-4" />
                </button>
            </div>
        </div>

        <!-- Body -->
        <div x-show="!isMinimized" x-collapse>
            <div class="max-h-80 overflow-y-auto p-3 space-y-3 bg-base-50">
                <template x-for="(upload, index) in uploads" :key="upload.id">
                    <div class="bg-base-100 border border-base-200 shadow-sm rounded-lg p-3 relative">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold truncate max-w-[200px]" x-text="upload.file.name"></span>
                            <button @click="cancelUpload(index)" class="btn btn-ghost btn-xs btn-circle text-error" title="{{ __('lang.cancel') }}">
                                <x-icon name="o-x-mark" class="w-3 h-3" />
                            </button>
                        </div>

                        <progress class="progress w-full h-1.5" :class="upload.progress == 100 ? 'progress-success' : 'progress-primary'" :value="upload.progress" max="100"></progress>

                        <div class="flex justify-between items-center mt-1">
                            <span class="text-[10px] opacity-70" x-text="upload.progress + '%'"></span>
                            <div class="flex gap-1 border border-base-200 bg-base-50 rounded-lg overflow-hidden">
                                <button x-show="!upload.isPaused && upload.progress < 100" @click="pauseUpload(index)" class="btn btn-ghost btn-xs rounded-none px-2" title="{{ __('lang.pause') }}">
                                    <x-icon name="o-pause" class="w-3 h-3" />
                                </button>
                                <button x-show="upload.isPaused && upload.progress < 100" @click="resumeUpload(index)" class="btn btn-ghost btn-xs rounded-none px-2" title="{{ __('lang.resume') }}">
                                    <x-icon name="o-play" class="w-3 h-3" />
                                </button>
                            </div>
                        </div>
                        <div x-show="upload.error" class="text-[10px] text-error mt-1" x-text="upload.error"></div>
                        <div x-show="upload.progress == 100" class="text-[10px] text-success mt-1 font-bold">{{ __('lang.upload_completed') }}</div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- bunnyGlobalUploader Alpine component is registered in resources/js/app.js --}}
</div>
@endpersist
