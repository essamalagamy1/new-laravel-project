import "../css/app.css";
import "../css/dashboard.css"; // ✅ CSS الخاص بالداشبورد

// Cairo Font (Local)
import "@fontsource/cairo/200.css";
import "@fontsource/cairo/300.css";
import "@fontsource/cairo/400.css";
import "@fontsource/cairo/500.css";
import "@fontsource/cairo/600.css";
import "@fontsource/cairo/700.css";
import "@fontsource/cairo/800.css";
import "@fontsource/cairo/900.css";

// Font Awesome
import "@fortawesome/fontawesome-free/css/all.min.css";

// Boxicons
import "boxicons/css/boxicons.min.css";

// Cropper.js
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";
window.Cropper = Cropper;

// Sortable.js
import Sortable from "sortablejs";
window.Sortable = Sortable;

// EasyMDE
import EasyMDE from "easymde";
import "easymde/dist/easymde.min.css";
window.EasyMDE = EasyMDE;

// intl-tel-input
import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
window.intlTelInput = intlTelInput;

// AOS (Animate On Scroll)
import AOS from "aos";
import "aos/dist/aos.css";
window.AOS = AOS;

//trix
import Trix from "trix";
window.Trix = Trix;

// tus-js-client for Bunny Stream direct uploads
import * as tus from "tus-js-client";
window.tus = tus;

// Register Alpine components before Alpine boots
document.addEventListener("alpine:init", () => {
    Alpine.data("bunnyGlobalUploader", () => ({
        uploads: [],
        isMinimized: false,
        isVisible: false,

        addUpload(detail) {
            this.isVisible = true;
            this.isMinimized = false;
            const file = detail.file;
            const authParams = detail.authParams;

            const uploadId = Date.now().toString();

            const uploadData = {
                id: uploadId,
                file: file,
                progress: 0,
                isPaused: false,
                error: null,
                tusUpload: null,
                onComplete: detail.onComplete || null,
            };

            this.uploads.push(uploadData);
            const index = this.uploads.length - 1;

            this.startTusUpload(index, authParams);
        },

        startTusUpload(index, authParams) {
            const upload = this.uploads[index];

            upload.tusUpload = new window.tus.Upload(upload.file, {
                endpoint: "https://video.bunnycdn.com/tusupload",
                retryDelays: [0, 3000, 5000, 10000, 20000],
                headers: {
                    AuthorizationSignature: authParams.signature,
                    AuthorizationExpire: authParams.expiration,
                    VideoId: authParams.videoId,
                    LibraryId: authParams.libraryId,
                },
                metadata: {
                    filename: upload.file.name,
                    filetype: upload.file.type || "video/mp4",
                },
                onError: (error) => {
                    console.error("Bunny Stream Upload Failed:", error);
                    this.uploads[index].error =
                        error.message || "Upload Failed";
                },
                onProgress: (bytesUploaded, bytesTotal) => {
                    const percentage = (
                        (bytesUploaded / bytesTotal) *
                        100
                    ).toFixed(0);
                    this.uploads[index].progress = percentage;
                },
                onSuccess: () => {
                    this.uploads[index].progress = 100;
                    if (typeof upload.onComplete === "function") {
                        upload.onComplete();
                    }
                },
            });

            upload.tusUpload.start();
        },

        pauseUpload(index) {
            if (this.uploads[index].tusUpload) {
                this.uploads[index].tusUpload.abort();
                this.uploads[index].isPaused = true;
            }
        },

        resumeUpload(index) {
            if (this.uploads[index].tusUpload) {
                this.uploads[index].tusUpload.start();
                this.uploads[index].isPaused = false;
                this.uploads[index].error = null;
            }
        },

        cancelUpload(index) {
            if (this.uploads[index].tusUpload) {
                this.uploads[index].tusUpload.abort();
            }
            this.removeUpload(this.uploads[index].id);
        },

        removeUpload(id) {
            this.uploads = this.uploads.filter((u) => u.id !== id);
        },

        closeUploader() {
            this.uploads.forEach((upload) => {
                if (upload.tusUpload && upload.progress < 100) {
                    upload.tusUpload.abort();
                }
            });
            this.uploads = [];
            this.isVisible = false;
        },
    }));
});

// Initialize AOS
document.addEventListener("DOMContentLoaded", () => {
    AOS.init();
});

// Re-initialize AOS after Livewire navigation
document.addEventListener("livewire:navigated", () => {
    AOS.refresh();
});
