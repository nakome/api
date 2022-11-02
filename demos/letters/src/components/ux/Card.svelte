<section class="card">
  <slot />
</section>

<style>
  .card {
    max-width: calc(100% - 10mm);
    margin: 10mm auto;
    padding: 2mm;
  }
  @media print{
    .card{
        display:none;
    }
  }
</style>
