import Quill from "quill";
import "quill/dist/quill.snow.css";

document.addEventListener("alpine:init", () => {
    Alpine.data("quillEditor", (content) => ({
        quill: null,
        content,

        init() {
            this.quill = new Quill(this.$refs.editor, {
                theme: "snow",
                modules: {
                    toolbar: [
                        [{ header: [1, 2, false] }],
                        ["bold", "italic", "underline"],
                        [
                            { align: ["", "center", "right", "justify"] },
                            { list: "ordered" },
                            { list: "bullet" },
                        ],
                        ["image", "video", "link"],
                    ],
                },
            });

            this.quill.root.innerHTML = this.content || "";

            this.quill.on("text-change", () => {
                this.content = this.quill.root.innerHTML;
            });

            this.$watch("content", (value) => {
                if (this.quill.root.innerHTML !== (value || "")) {
                    this.quill.root.innerHTML = value || "";
                }
            });
        },
    }));
});
