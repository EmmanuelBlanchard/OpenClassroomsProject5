window.onload = () => {
    const FiltersForm = document.querySelector("#filters");

    // We loop on the inputs
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", () => {
            // Here we intercept the clicks 
            // We collect the data from the form
            const Form = new FormData(FiltersForm);

            // We create the "queryString"
            const Params = new URLSearchParams();

            Form.forEach((value, key) => {
                Params.append(key, value);
            });

            // We recover the active url
            const Url = new URL(window.location.href);

            // We launch the ajax request
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response =>
                response.json()
            ).then(data => {
                // We will search the content area
                const content = document.querySelector("#content");

                // We replace the content
                content.innerHTML = data.content;

                // We update the url
                history.pushState({}, null, Url.pathname + "?" + Params.toString());
            }).catch(e => alert(e));

        });
    });

}