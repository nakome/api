<script>
  export let total;
  export let limit;
  export let offset;
  export let handlePagination;

  let totalPages = Math.ceil(total / limit) - 1;
  let last = Math.floor(total % limit);
</script>

<div class="btn-pages">
  <button
    class="btn"
    disabled={offset === 0}
    on:click={() => handlePagination(limit, --offset * limit)}
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="16"
      height="16"
      fill="currentColor"
      class="bi bi-arrow-left-circle"
      viewBox="0 0 16 16"
    >
      <path
        fill-rule="evenodd"
        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"
      />
    </svg>
    <span>Prev</span>
  </button>

  <button
    class="btn"
    disabled={offset === totalPages}
    on:click={() => handlePagination(limit, ++offset * limit)}
  >
    <span>Next</span>
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="16"
      height="16"
      fill="currentColor"
      class="bi bi-arrow-right-circle"
      viewBox="0 0 16 16"
    >
      <path
        fill-rule="evenodd"
        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"
      />
    </svg>
  </button>
</div>

<style>
  .btn-pages {
    display: flex;
    justify-content: flex-end;
    overflow: hidden;
    background: var(--light-1);
    border: 1px solid var(--light-3);
    border-top: none;
    padding: 2mm;
    user-select: none;
  }
  .btn {
    display: inline-block;
    padding: 2mm;
    line-height: 3mm;
    cursor: pointer;
    text-transform: capitalize;
    text-decoration: none;
    background: var(--light-1);
    border: 1px solid var(--light-3);
    color: var(--black-3);
    border-radius: 0.5mm;
    transition: all 500ms ease;
  }
  .btn span {
    width: 10mm;
    height: 5mm;
    display: inline-block;
    line-height: 5mm;
  }
  .btn svg {
    width: 5mm;
    height: 5mm;
    margin: -1mm 0;
  }

  .btn:first-child {
    margin-right: 2mm;
  }
  .btn:disabled {
    background: var(--light-3);
    border: 1px solid var(--light-3);
    color: var(--black-1);
  }
  .btn:disabled:hover,
  .btn:disabled:focus {
    background: var(--black-1);
    border: 1px solid var(--black-1);
    color: var(--light-1);
  }
  .btn:hover,
  .btn:focus {
    background: var(--light-1);
    border: 1px solid var(--black-2);
    color: var(--black-3);
    transition: all 500ms ease;
  }
</style>
