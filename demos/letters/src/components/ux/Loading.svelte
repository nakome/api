<script>
    export let msg;
</script>

<section class="loading">
    <h3>{msg}</h3>
    <div class="preloader">
      <span></span>
    </div>
</section>

<style>
  .loading {
    max-width: 80mm;
    padding: 1rem;
    margin: 1rem;
    background: var(--light-1);
    border: 1px solid var(--light-2);
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
    height: 50mm;
    flex-direction: column;
  }
  .loading h3 {
    color: var(--black-1);
    font-size: 1.8rem;
    margin-bottom: 1rem;
  }

  .preloader {
    width: 48px;
    height: 48px;
    border: 5px solid var(--blue-1);
    border-bottom-color: var(--blue-2);
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 
</style>