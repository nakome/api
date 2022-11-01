<script>
    export let msg;
</script>

<section class="info">
    <h3>{msg}</h3>
    <slot/>
</section>

<style>
  .info {
    width: calc(100% - 2rem);
    max-width: 110mm;
    padding: 1rem;
    margin: 1rem;
    background: var(--red-1);
    border: 1px solid var(--red-3);
    color: var(--red-3);
  }
  .info h3 {
    color: var(--red-3);
    font-size: 1.8rem;
    margin-bottom: 1rem;
  }
</style>