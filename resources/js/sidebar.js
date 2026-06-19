export function initSidebar() {
    document.querySelectorAll(".nav-parent").forEach(parent => {

        const toggle = parent.querySelector(".cursor-pointer");
        const submenu = parent.querySelector(".submenu-container");
        const icon = parent.querySelector(".icon-rotate");

        if (!toggle || !submenu || !icon) return;

        toggle.addEventListener("click", () => {

            const isOpen = submenu.classList.contains("max-h-96");

            if (isOpen) {

                submenu.classList.remove("max-h-96", "opacity-100");
                submenu.classList.add("max-h-0", "opacity-0");

                icon.classList.remove("rotate-180");
                parent.classList.remove("bg-slate-700/30");

            } else {

                submenu.classList.remove("max-h-0", "opacity-0");
                submenu.classList.add("max-h-96", "opacity-100");

                icon.classList.add("rotate-180");
                parent.classList.add("bg-slate-700/30");

            }

        });

        if (submenu.classList.contains("max-h-96")) {
            parent.classList.add("bg-slate-700/30");
            icon.classList.add("rotate-180");
        }

    });
}