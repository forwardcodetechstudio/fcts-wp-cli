(function () {
    /**
     * WP User Profile Tabs
     * Beschreibung:
     * Gruppieren der Felder der Benutzerprofilseite unter Registerkarten.
     * Alle Felder im Benutzerprofil, gegliedert durch H2, werden durch dieses script in Tabs organisiert.
     * Es werden nur die Felder neu organisiert. Die eingebundenen Javascript-Listener werden nicht berührt.
     * Version: 1.3
     * Create: 10.08.2022
     * Author: Paul Brand (brand@litterarius.eu)
     */

    /**
     * Erstellen eines Containerknotens.
     *
     * @param {String} tagName
     * @param {String} className
     *
     * @returns
     */
    function createContainer(tagName = 'div', className = 'container') {
        const element = document.createElement(tagName);
        element.classList.add(className);
        return element;
    }

    /**
     * Registerkarten-Link erstellen (TABS).
     *
     * @param {String} innerText
     * @param {HTMLElement} tabs
     * @param {HTMLElement} targetTab
     * @param {String} tagName
     * @param {String} className
     *
     * @returns
     */
     function createTabLink(innerText, tabs, targetTab, tagName = 'a', className = 'tab-link') {
        const wrapper = document.createElement('li');
        wrapper.className = `${className}-wrapper`;

        const link = document.createElement(tagName);
        link.innerText = innerText;
        link.href = '#';
        link.classList.add(className);
        link.addEventListener('click', function (event) {
            event.preventDefault();

            for (let siblingWrapper of event.target.parentNode.parentNode.children) {
                if (siblingWrapper.isEqualNode(wrapper)) {
                    siblingWrapper.querySelector('a').classList.add('active');
                    continue;
                }
                siblingWrapper.querySelector('a').classList.remove('active');
            }
            for (let siblingTab of tabs.children) {
                if (siblingTab.isEqualNode(targetTab)) {
                    siblingTab.classList.add('active');
                    continue;
                }
                siblingTab.classList.remove('active');
            }
        });
        wrapper.appendChild(link);
        return wrapper;
    }

    /**
     * Höhe eines Elementes messen.
     *
     * @param {HTMLElement} el
     * @returns
     */
    function getElementHeight(el) {
        var styles = window.getComputedStyle(el);
        var margin = parseFloat(styles['marginTop']) +
               parseFloat(styles['marginBottom']);
        return Math.ceil(el.offsetHeight + margin);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const profileForm = document.querySelector('form#your-profile');
        if (typeof profileForm === 'undefined') {
            // nichts tun, wenn das Profilformular nicht vorhanden ist.
            return;
        }

        // Alle versteckten Eingabefelder in das Formularelement verschieben (top level).
        // dann alle Absätze, die nach der Migration nichts mehr enthalten entfernen.
        document.querySelectorAll('form#your-profile > p').forEach((el) => {
            el.querySelectorAll('input[type=hidden]').forEach((input) => {
                profileForm.prepend(input);
            });
            if (el.innerHTML.trim().length === 0) {
                el.remove();
            }
        });
    });

    window.addEventListener('load', function () {
        const profileForm = document.querySelector('form#your-profile');
        if (typeof profileForm === 'undefined') {
            // nichts tun, wenn das Profilformular nicht vorhanden ist.
            return;
        }

        const submit = profileForm.querySelector('p.submit')

        // Der Container, in den die Registerkarten gelegt werden
        const theContainer = profileForm;

        let container = createContainer();
        container.classList.add('user-profile-tabs');
        submit.before(container);
        let tabLinks = createContainer('ul', 'tab-links');
        container.appendChild(tabLinks);
        let tabs = createContainer('div', 'tabs');
        container.appendChild(tabs);

        let tab = null;
        let firstTab = true;
        for (let n of Array.from(theContainer.childNodes)) {
            // Verhinderung der Nutzung von Tabs oder des Submit-Button-Wrappers.
            if (n.isSameNode(container) || n.isSameNode(submit)) {
                continue;
            }

            // Überspringen der Erfassung leerer Textknoten.
            if (n.nodeType === Node.TEXT_NODE && n.textContent.trim() === '') {
                continue;
            }

            // Suche nach Überschriften in Knotenelementen zum Erstellen von Registerkarten.
            if (n.nodeType === Node.ELEMENT_NODE) {
                // Registerkarte für jedes h3 erstellen
                if (n.tagName.toUpperCase() === 'H2' || n.tagName.toUpperCase() === 'H3') {
                    tab = createContainer('div', 'tab');
                    tabs.appendChild(tab);
                    tabLinks.appendChild(createTabLink(n.innerText, tabs, tab));
                } else if (n.querySelector('h2, h3') !== null) {
                    tab = createContainer('div', 'tab');
                    tabs.appendChild(tab);
                    tabLinks.appendChild(createTabLink(
                        n.querySelector('h2').innerText, tabs, tab
                    ));
                }
            }

            // Warten, wenn es keine Registerkarte gibt.
            if (tab === null) {
                continue;
            }

            // Wenn die Registerkarte die erste Registerkarte ist, auf aktiv setzen.
            if (firstTab) {
                tab.classList.add('active');
                tabLinks.querySelector('a').classList.add('active');
                firstTab = false;
            }

            // Element in den Containers verschieben.
            tab.appendChild(n);
        }

        // Der Container muss mindestens so hoch sein wie die niedrigste Registerkarte.
        let maxTabHeight = 0;
        for (let tab of tabs.childNodes) {
            let tabHeight = getElementHeight(tab);
            maxTabHeight = (tabHeight > maxTabHeight)
                ? tabHeight : maxTabHeight;
        }
        tabs.style.minHeight = `${maxTabHeight}px`;
    });
})();
