import DetailField from "./components/DetailField";
import FilterField from "./components/FilterField";
import FormField from "./components/FormField";
import IndexField from "./components/IndexField";
import PreviewField from "./components/PreviewField";

Nova.booting((app, store) => {
    app.component("detail-text-mask", DetailField);
    app.component("filter-text-mask", FilterField);
    app.component("form-text-mask", FormField);
    app.component("index-text-mask", IndexField);
    app.component("preview-text-mask", PreviewField);
});
