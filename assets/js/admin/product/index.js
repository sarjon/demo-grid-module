import Grid from '../../../../../../admin-dev/themes/new-theme/js/components/grid/grid';
import FiltersResetExtension
  from "../../../../../../admin-dev/themes/new-theme/js/components/grid/extension/filters-reset-extension";
import SortingExtension
  from "../../../../../../admin-dev/themes/new-theme/js/components/grid/extension/sorting-extension";

const $ = window.$;

$(document).ready(() => {
  const productGrid = new Grid('demogrid_products');

  productGrid.addExtension(new FiltersResetExtension());
  productGrid.addExtension(new SortingExtension());
});
