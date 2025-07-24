(function ($) {
    /**
     * jslint maxparams: 4, maxdepth: 4, maxstatements: 20, maxcomplexity: 8
     */
   (function (w) {
        let hoverIndex = 0;
        const document = w.document,
            ATTRIBUTE_FOR_EVENT_ALREADY_BOUND = "data-vendi-popup-bound",
            getBlankImageSrc = () => {
                return w.theme_var.icon +"noimage.jpg";
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
                const imagePath = w.theme_var.upload && w.theme_var.upload[filename]?w.theme_var.upload[filename]:getBlankImageSrc();
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
              // console.log(w.theme_var);
              
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
