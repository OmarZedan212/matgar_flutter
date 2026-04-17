@extends('layouts.app')
@section('title','Loading')

@section('style')
<style>
    
    #preloader {
        position: fixed;
        inset: 0;
        background: #121212;
        z-index: 999999;
        display: grid;
        place-items: center;
        overflow: hidden;
    }

    h2 {
        font-size: 3rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin: 0;
        font-family: "Poppins", sans-serif;
        color: #e6eef8;
        z-index: 2;
        position: relative;
    }

    h2 .char {
        display: inline-block;
        will-change: transform, opacity;
        white-space: pre;
    }

    .shape {
        position: absolute;
        width: 30px;
        height: 30px;
        background: rgba(255,255,255,.15);
        border-radius: 8px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }
</style>

</style>
@endsection

@section('content')

<!-- Loading Screen -->
    <div id="preloader">
        <h2 id="title">Matger</h2>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
@endsection

@section('scripts')
<script>
    // ====== PRELOADER HIDE ON PAGE LOAD ======
    window.addEventListener("load", () => {
        const loader = document.getElementById("preloader");

        // fade out smoothly
        loader.style.transition = "10s";
        loader.style.opacity = 10;

        setTimeout(() => loader.style.display = "none", 600);
    });

    // ======== Text Animation ========
    const title = document.querySelector("#title");
    const text = title.textContent;
    title.textContent = "";

    const chars = Array.from(text).map((ch) => {
        const span = document.createElement("span");
        span.className = "char";
        span.textContent = ch === " " ? "\u00A0" : ch;
        title.appendChild(span);
        return span;
    });

    chars.forEach((el, i) => {
        el.animate(
        [
            { transform: "translateY(0)", opacity: 1 },
            { transform: "translateY(-32px)", opacity: 1 },
        ],
        {
            duration: 600,
            delay: i * 100,
            direction: "alternate",
            iterations: Infinity,
            easing: "cubic-bezier(.42,0,.58,1)",
            fill: "both",
        }
        );
    });

    // ======== Shapes ========
    const shapes = document.querySelectorAll(".shape");

    function random(min, max) {
        return Math.random() * (max - min) + min;
    }

    function animateShapes() {
        shapes.forEach((shape) => {
        const x = random(-100, 100);
        const y = random(-100, 100);
        const rotate = random(-180, 180);
        const duration = random(500, 1000);

        shape.animate(
            [
            { transform: "translate(-50%, -50%)" },
            {
                transform: `translate(calc(-50% + ${x}px), calc(-50% + ${y}px)) rotate(${rotate}deg)`
            }
            ],
            {
            duration,
            direction: "alternate",
            iterations: Infinity,
            easing: "ease-in-out",
            }
        );
        });
    }

    animateShapes();
</script>

@endsection