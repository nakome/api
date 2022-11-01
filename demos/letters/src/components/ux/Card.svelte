<section class="card">
  <slot />
</section>

<style>
  .card {
    max-width: 160mm;
    margin: 10mm auto;
    padding: 2mm;
  }
  @media print{
    .card{
        display:none;
    }
  }
</style>
