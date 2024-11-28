document.addEventListener("DOMContentLoaded", () => {
    const productForm = document.getElementById("product-form");
    const productList = document.getElementById("product-list");
    let products = [];

    // Add or update product
    productForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const image = document.getElementById("image").files[0];
        const description = document.getElementById("description").value;
        const contact = document.getElementById("contact").value;
        const region = document.getElementById("region").value;
        const price = document.getElementById("price").value;
        const status = document.getElementById("status").value;

        const product = {
            id: Date.now(),
            image: URL.createObjectURL(image),
            description,
            contact,
            region,
            price,
            status,
        };

        products.push(product);
        renderProducts();
        productForm.reset();
    });

    // Render products
    function renderProducts() {
        productList.innerHTML = "";
        products.forEach((product) => {
            const card = document.createElement("div");
            card.classList.add("product-card");

            card.innerHTML = `
                <img src="${product.image}" alt="Coconut">
                <h3>${product.description}</h3>
                <p>Contact: ${product.contact}</p>
                <p>Region: ${product.region}</p>
                <p>Price: $${product.price}</p>
                <p>Status: ${product.status}</p>
                <button class="edit">Edit</button>
                <button class="delete">Delete</button>
            `;

            // Edit functionality
            card.querySelector(".edit").addEventListener("click", () => {
                document.getElementById("description").value = product.description;
                document.getElementById("contact").value = product.contact;
                document.getElementById("region").value = product.region;
                document.getElementById("price").value = product.price;
                document.getElementById("status").value = product.status;

                products = products.filter((p) => p.id !== product.id);
                renderProducts();
            });

            // Delete functionality
            card.querySelector(".delete").addEventListener("click", () => {
                products = products.filter((p) => p.id !== product.id);
                renderProducts();
            });

            productList.appendChild(card);
        });
    }
});
