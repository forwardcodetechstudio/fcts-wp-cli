(function ($) {
    /**
     * jslint maxparams: 4, maxdepth: 4, maxstatements: 20, maxcomplexity: 8
     */
    (function (w) {
        let hoverIndex = 0;
        const document = w.document,
            ATTRIBUTE_FOR_EVENT_ALREADY_BOUND = "data-vendi-popup-bound",
            getBlankImageSrc = () => {
                return "data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAAeAAD/4QMsaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjUtYzAyMSA3OS4xNTQ5MTEsIDIwMTMvMTAvMjktMTE6NDc6MTYgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpDQTVEMkZFNTY3QUYxMUU0QjMxNUNENjk5MDk0NTEzNiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpDQTVEMkZFNjY3QUYxMUU0QjMxNUNENjk5MDk0NTEzNiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkNBNUQyRkUzNjdBRjExRTRCMzE1Q0Q2OTkwOTQ1MTM2IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkNBNUQyRkU0NjdBRjExRTRCMzE1Q0Q2OTkwOTQ1MTM2Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+/+4ADkFkb2JlAGTAAAAAAf/bAIQAEAsLCwwLEAwMEBcPDQ8XGxQQ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";
            },
            setImage = (img, imagePath, thisIndex) => {
                const g = new Image();

                g.addEventListener("load", () => {
                    if (thisIndex === hoverIndex) {
                        img.src = g.src;
                    }
                });

                g.addEventListener("error", () => {
                    if (thisIndex === hoverIndex) {
                        img.src = getBlankImageSrc();
                    }
                });

                g.src = imagePath;
            },
            createPreview = (outerNode) => {
                const outerDiv = document.createElement("div");
                outerDiv.classList.add("preview");

                const innerDiv = document.createElement("div");
                innerDiv.classList.add("inner-preview");

                const img = document.createElement("img");

                innerDiv.appendChild(img);
                outerDiv.appendChild(innerDiv);

                outerNode.appendChild(outerDiv);
                return outerDiv;
            },
            getPreview = (outerNode) => {
                return outerNode.querySelector(".preview");
            },
            getOrCreatePreview = (outerNode) => {
                return getPreview(outerNode) || createPreview(outerNode);
            },
            doStuffWithThing = (outerNode, link) => {
                const filename = link.getAttribute("data-layout");
                const preview = getOrCreatePreview(outerNode);
                const img = preview.querySelector("img");
                const thisIndex = ++hoverIndex;
                const imagePath = w.theme_var.upload + filename + ".png";
                setImage(img, imagePath, thisIndex);
            },
            lookForNewThings = () => {
                const nodes = document.querySelectorAll(".acf-fc-popup");

                Array.from(nodes).forEach((node) => {
                    Array.from(node.querySelectorAll("li a")).forEach((link) => {
                        if (link.hasAttribute(ATTRIBUTE_FOR_EVENT_ALREADY_BOUND)) {
                            return;
                        }

                        link.setAttribute(ATTRIBUTE_FOR_EVENT_ALREADY_BOUND, "true");

                        link.addEventListener("mouseover", () => {
                            doStuffWithThing(node, link);
                        });
                    });
                });
            },
            onload = () => {
                if (!w.theme_var || !w.theme_var.upload) {
                    return;
                }

                const target = document.body;
                const config = {
                    attributes: true,
                    childList: true,
                    subtree: true,
                    attributeFilter: ["class"],
                };

                const callback = function (mutationsList, observer) {
                    for (const mutation of mutationsList) {
                        if (mutation.type === "childList") {
                            // Look for at least one ACF popup item added
                            const foundNewThings = Array.from(mutation.addedNodes).some(
                                (node) => {
                                    return (
                                        node.classList && node.classList.contains("acf-fc-popup")
                                    );
                                }
                            );

                            // If we found at least one, call a global bind.
                            // Technically we could bind to each specific item found but it is cleaner
                            // to just re-spider the entire DOM. Perf shouldn't be affected by this.
                            if (foundNewThings) {
                                lookForNewThings();
                                return;
                            }
                        }
                    }
                };

                const observer = new MutationObserver(callback);
                observer.observe(target, config);

                // No matter what, call the page searcher at least once
                lookForNewThings();
            },
            init = () => {
                if (
                    document.readyState &&
                    ("complete" === document.readyState ||
                        "loaded" === document.readyState)
                ) {
                    onload();
                } else {
                    document.addEventListener("DOMContentLoaded", onload);
                }
            };

        init();
    })(window);
})(jQuery);
