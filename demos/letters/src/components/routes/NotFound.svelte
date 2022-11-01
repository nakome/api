<script>
  import { link } from "svelte-spa-router";
  // ux components
  import Info from "../ux/Info.svelte";

</script>


<Info msg="404 not found">
  <p>We can't seem to find the resource you're looking for.</p>
  <p><a href="/" use:link>Back</a></p>
</Info>