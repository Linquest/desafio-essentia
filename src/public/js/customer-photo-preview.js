(() => {
    const input = document.getElementById("photo");
    const preview = document.getElementById("photo-preview");

    if (!input || !preview) {
        return;
    }

    const originalSource = preview.getAttribute("src");
    let temporaryUrl = null;

    function releaseTemporaryUrl() {
        if (temporaryUrl !== null) {
            URL.revokeObjectURL(temporaryUrl);
            temporaryUrl = null;
        }
    }

    function restoreOriginal() {
        if (originalSource) {
            preview.src = originalSource;
        } else {
            preview.removeAttribute("src");
        }

        preview.hidden = !originalSource;
    }

    input.addEventListener("change", () => {
        releaseTemporaryUrl();

        const file = input.files[0];

        if (!file) {
            restoreOriginal();
            return;
        }

        temporaryUrl = URL.createObjectURL(file);
        preview.src = temporaryUrl;
        preview.hidden = false;
    });

    preview.addEventListener("error", () => {
        if (temporaryUrl !== null) {
            releaseTemporaryUrl();
            restoreOriginal();
        }
    });
})();
