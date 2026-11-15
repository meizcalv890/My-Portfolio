document.addEventListener("DOMContentLoaded", () => {
    const reduceMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;
    const finePointer = window.matchMedia(
        "(hover: hover) and (pointer: fine)",
    ).matches;

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
        const navObserver = new IntersectionObserver(
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
        sections.forEach((s) => navObserver.observe(s));
    }

    // Bilah progres scroll + tombol kembali ke atas
    const bar = document.getElementById("progress");
    const toTop = document.getElementById("to-top");
    let ticking = false;
    const onScroll = () => {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        const p = max > 0 ? Math.min(1, window.scrollY / max) : 0;
        if (bar) bar.style.setProperty("--p", p.toFixed(4));
        if (toTop) toTop.dataset.show = String(window.scrollY > 700);
        ticking = false;
    };
    window.addEventListener(
        "scroll",
        () => {
            if (!ticking) {
                ticking = true;
                requestAnimationFrame(onScroll);
            }
        },
        { passive: true },
    );
    onScroll();

    // Bergeser masuk saat di-scroll
    const revealEls = document.querySelectorAll(".reveal");
    if (reduceMotion || !("IntersectionObserver" in window)) {
        revealEls.forEach((el) => el.classList.add("in"));
    } else {
        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add("in");
                    revealObserver.unobserve(entry.target);
                });
            },
            { threshold: 0.1, rootMargin: "0px 0px -5% 0px" },
        );
        revealEls.forEach((el) => revealObserver.observe(el));
    }

    // Foto hero miring mengikuti kursor
    if (finePointer && !reduceMotion) {
        document.querySelectorAll("[data-tilt]").forEach((el) => {
            el.addEventListener("mousemove", (e) => {
                const r = el.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - 0.5;
                const y = (e.clientY - r.top) / r.height - 0.5;
                el.style.setProperty("--ry", (x * 10).toFixed(2) + "deg");
                el.style.setProperty("--rx", (-y * 10).toFixed(2) + "deg");
            });
            el.addEventListener("mouseleave", () => {
                el.style.setProperty("--ry", "0deg");
                el.style.setProperty("--rx", "0deg");
            });
        });
    }

    // Label yang mengikuti kursor di elemen [data-cursor]
    const label = document.getElementById("cursor-label");
    if (label && finePointer) {
        let x = 0;
        let y = 0;
        let frame = null;
        document.addEventListener("mousemove", (e) => {
            x = e.clientX;
            y = e.clientY;
            if (frame) return;
            frame = requestAnimationFrame(() => {
                label.style.transform =
                    "translate3d(" + x + "px," + y + "px,0)";
                frame = null;
            });
        });
        document.addEventListener("mouseover", (e) => {
            const target = e.target.closest
                ? e.target.closest("[data-cursor]")
                : null;
            if (target) {
                label.textContent = target.dataset.cursor || "Lihat";
                label.classList.add("on");
            }
        });
        document.addEventListener("mouseout", (e) => {
            const from = e.target.closest
                ? e.target.closest("[data-cursor]")
                : null;
            const to =
                e.relatedTarget && e.relatedTarget.closest
                    ? e.relatedTarget.closest("[data-cursor]")
                    : null;
            if (from && !to) label.classList.remove("on");
        });
    }

    // Lightbox untuk elemen [data-zoom]
    const box = document.getElementById("lightbox");
    const boxImg = document.getElementById("lightbox-img");
    if (box && boxImg && typeof box.showModal === "function") {
        document.addEventListener("click", (e) => {
            const t = e.target.closest ? e.target.closest("[data-zoom]") : null;
            if (!t) return;
            const src = t.dataset.zoom || t.getAttribute("href");
            if (!src) return;
            e.preventDefault();
            boxImg.src = src;
            boxImg.alt = t.getAttribute("aria-label") || "";
            box.showModal();
        });
        box.addEventListener("click", () => box.close());
        box.addEventListener("close", () => boxImg.removeAttribute("src"));
    }

    // Logo yang gagal dimuat sebelum skrip ini jalan
    document.querySelectorAll("img[data-fallback]").forEach((img) => {
        if (img.complete && img.naturalWidth === 0) showLogoFallback(img);
    });
});

// Logo yang gagal dimuat: ganti dengan huruf awal
function showLogoFallback(img) {
    img.classList.add("hidden");
    const letter = img.parentElement
        ? img.parentElement.querySelector(".logo-letter")
        : null;
    if (letter) letter.classList.remove("hidden");
}

document.addEventListener(
    "error",
    (e) => {
        const t = e.target;
        if (t && t.tagName === "IMG" && t.hasAttribute("data-fallback"))
            showLogoFallback(t);
    },
    true,
);

// Konfirmasi hapus: <form data-confirm="Pesan konfirmasi">
document.addEventListener("submit", (e) => {
    const message = e.target.dataset ? e.target.dataset.confirm : null;
    if (message && !window.confirm(message)) {
        e.preventDefault();
    }
});
