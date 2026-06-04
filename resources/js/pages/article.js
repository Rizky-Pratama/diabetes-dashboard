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

    Alpine.data("quillViewer", (content) => ({
        quill: null,
        content,

        init() {
            this.quill = new Quill(this.$refs.viewer, {
                theme: "snow",
                readOnly: true,
                modules: {
                    toolbar: null,
                },
            });

            this.setContent(this.content);

            this.$watch("content", (value) => {
                this.setContent(value);
            });
        },

        setContent(value) {
            const content = value || "";

            if (this.quill.root.innerHTML === content) {
                return;
            }

            this.quill.setContents([]);
            this.quill.clipboard.dangerouslyPasteHTML(content);
            this.quill.enable(false);
        },
    }));
});
