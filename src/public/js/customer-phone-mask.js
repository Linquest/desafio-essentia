(() => {
    const input = document.getElementById("phone");

    function formatPhone(value) {
        const digits = value.replace(/\D/g, "");

        if (!digits) {
            return "";
        }

        // Preserva números fora do formato brasileiro esperado.
        if (digits.length > 11) {
            return value;
        }

        if (digits.length <= 2) {
            return `(${digits}`;
        }

        const ddd = digits.slice(0, 2);
        const number = digits.slice(2);
        const prefixLength = digits.length === 11 ? 5 : 4;
        const prefix = number.slice(0, prefixLength);
        const suffix = number.slice(prefixLength);

        return `(${ddd}) ${prefix}${suffix ? `-${suffix}` : ""}`;
    }

    document.querySelectorAll("[data-phone-mask]").forEach((element) => {
        element.textContent = formatPhone(element.textContent.trim());
    });

    if (!input) {
        return;
    }

    function applyMask() {
        const value = input.value;
        const cursor = input.selectionStart ?? value.length;
        const digitsBeforeCursor = value
            .slice(0, cursor)
            .replace(/\D/g, "").length;

        const formatted = formatPhone(value);

        if (formatted === value) {
            return;
        }

        input.value = formatted;

        if (document.activeElement !== input) {
            return;
        }

        let position = 0;
        let digitsFound = 0;

        while (
            position < formatted.length &&
            digitsFound < digitsBeforeCursor
        ) {
            if (/\d/.test(formatted[position])) {
                digitsFound++;
            }

            position++;
        }

        input.setSelectionRange(position, position);
    }

    input.addEventListener("input", applyMask);
    applyMask();
})();
