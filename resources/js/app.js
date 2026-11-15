document.addEventListener("DOMContentLoaded", () => {
    // Menu hamburger
    const btn = document.getElementById("menu-btn");
    const menu = document.getElementById("mobile-menu");
    if (btn && menu) {
        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
            btn.setAttribute(
                "aria-expanded",
                String(!menu.classList.contains("hidden")),
            );
        });
        menu.querySelectorAll("a").forEach((a) =>
            a.addEventListener("click", () => {
                menu.classList.add("hidden");
                btn.setAttribute("aria-expanded", "false");
            }),
        );
    }

    // Menu menyala sesuai bagian yang sedang dilihat
    const sections = document.querySelectorAll("main section[id]");
    const links = document.querySelectorAll("[data-nav]");
    if (sections.length && links.length && "IntersectionObserver" in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    links.forEach((l) =>
                        l.setAttribute(
                            "aria-current",
                            String(l.hash === "#" + entry.target.id),
                        ),
                    );
                });
            },
            { rootMargin: "-45% 0px -50% 0px" },
        );
        sections.forEach((s) => observer.observe(s));
    }
});

// Konfirmasi hapus: <form data-confirm="Pesan konfirmasi">
document.addEventListener("submit", (e) => {
    const message = e.target.dataset ? e.target.dataset.confirm : null;
    if (message && !window.confirm(message)) {
        e.preventDefault();
    }
});
