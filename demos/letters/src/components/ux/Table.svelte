<script>
  import { link } from "svelte-spa-router";

  export let data;
</script>

<section class="table-responsive">
  <table>
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Description</th>
      <th>Update</th>
      <th>Options</th>
    </tr>

    {#each data.DATA as letter}
      <tr>
        <td>{letter.uid}</td>
        <td>{letter.title}</td>
        <td
          ><div class="truncate">
            {letter.description}
          </div></td
        >
        <td>{letter.updated}</td>
        <td>
          <a use:link href={`/edit/${letter.uid}`}>Edit</a>
          <a use:link href={`/delete/${letter.uid}/${letter.token}`}>Delete</a>
        </td>
      </tr>
    {/each}
  </table>
</section>


<style>

table,
  td,
  th {
    border: 1px solid var(--light-3);
    text-align: left;
  }

  th {
      background: var(--light-2);
      border: 1px solid var(--light-3);
      color:var(--black-1);
  }
  td {
      background: var(--light-1);
  }
  td:first-child{
    font-weight:bold;
    color:var(--black-1);
  }

  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 5mm;
  }

  th,
  td {
    padding: 2mm;
  }

  table a {
    display: inline-block;
    padding: 3mm;
    line-height: 3mm;
    cursor: pointer;
    text-transform: capitalize;
    text-decoration: none;
    background: var(--blue-2);
    border: 1px solid var(--blue-3);
    color: var(--blue-1) !important;
    margin-bottom: 2mm;
    border-radius: 0.5mm;
    transition:all 500ms ease;
  }
  table a:hover,
  table a:focus{
    background: var(--blue-1);
    border: 1px solid var(--blue-2);
    color: var(--blue-3) !important;
    transition:all 500ms ease;
  }

  table a:last-child {
    background: var(--red-3);
    border: 1px solid var(--red-3);
    color: var(--red-1)!important;
  }

  table a:last-child:hover,
  table a:last-child:focus {
    background: var(--red-1);
    border: 1px solid var(--red-3);
    color: var(--red-3)!important;
  }

  .table-responsive {
    overflow-x: auto;
  }
  .truncate{
    background: var(--light-1);
    width: 79mm;
    text-emphasis: inherit;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    display: block;
  }
</style>