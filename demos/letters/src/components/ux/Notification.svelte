<script>
    import { fade } from 'svelte/transition';

    export let title;
    export let desc;
    export let type;
    export let active;
</script>

{#if active}
    <section class={`notification notification-${type}`} transition:fade="{{delay: 250, duration: 300}}">
        <h3>{title}</h3>
        <p>{desc}</p>
    </section>
{/if}

<style>
    .notification {
        position:absolute;
        bottom:5mm;
        right:5mm;
        margin:2mm;
        padding:3mm;
        width:80mm;
        max-width:100mm;
        border-radius:0.7mm;
        background:var(--light-1);
        border:1px solid var(--light-3);
        color:var(--black-1);
        box-shadow: 0px 4px 4px -4px var(--black-3);
    }
    .notification h3{
        color:var(--black-3);
    }
    .notification p {
        font-style: italic;
    }

    .notification-error {
        background:var(--red-3);
        border:1px solid var(--red-3);
        color:var(--light-3);
    }

    .notification-error h3{
        color:var(--red-2);
    }

    .notification-success {
        background:var(--blue-3);
        border:1px solid var(--blue-3);
        color:var(--light-3);
    }

    .notification-success h3{
        color:var(--blue-2);
    }
</style>