<script>
  import Router from "svelte-spa-router";
  import { wrap } from "svelte-spa-router/wrap";

  // routes
  import Home from "./routes/Home.svelte";
  import Edit from "./routes/Edit.svelte";
  import NotFound from "./routes/NotFound.svelte";
  import NewLetter from "./routes/NewLetter.svelte";
  import Delete from "./routes/Delete.svelte";

  const routes = {
    "/": wrap({ component: Home }),
    "/new": wrap({ component: NewLetter }),
    "/edit/:uid": wrap({ component: Edit }),
    "/delete/:uid/:token": wrap({ component: Delete }),
    "*": wrap({ component: NotFound }),
  };
</script>

<Router {routes} />
