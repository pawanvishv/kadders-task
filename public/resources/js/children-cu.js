async function fetchChildParent(id) {
    axios
        .get(`/fetchChildParent?child=no`, {
            headers: {
                Accept: "application/json",
            },
        })
        .then((response) => {
            const users = response.data.data;
            const select = document.getElementById(`c${id}-parents`);
            const selectChildren = document.getElementById(`c${id}-children`);
            select.innerHTML = "";
            if (selectChildren) selectChildren.innerHTML = "";

            users.forEach((user) => {
                const option = document.createElement("option");
                option.value = user.id;
                option.textContent = `${user.first_name} ${user.last_name}`;
                select.appendChild(option);
            });

            if (selectChildren) {
                users.forEach((user) => {
                    const option = document.createElement("option");
                    option.value = user.id;
                    option.textContent = `${user.first_name} ${user.last_name}`;
                    selectChildren.appendChild(option);
                });
            }

            $(select).select2({ width: "100%" }).trigger("change");
            if (selectChildren)
                $(selectChildren).select2({ width: "100%" }).trigger("change");
        })
        .catch((error) => {
            console.error("Error fetching children:", error);
        });
}

const app = {
    parentId: 0,
    childId: 0,
    files: {},

    async loadLocations() {
        try {
            // Fetch all countries
            const countriesRes = await fetch("/locations");
            this.countries = await countriesRes.json();

            console.log("Countries loaded:", this.countries.length);
        } catch (error) {
            console.error("Error loading locations:", error);
            this.loadFallbackData();
        }
    },

    async updateStates(select, id) {
        const countryId = select.value;
        const stateSelect = document.getElementById(`${id}-state`);
        stateSelect.innerHTML = '<option value="">Loading...</option>';
        if (countryId) {
            try {
                const res = await fetch(`/locations?country_id=${countryId}`);
                const states = await res.json();

                stateSelect.innerHTML = '<option value="">Select</option>';
                states.forEach((state) => {
                    stateSelect.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                });
            } catch (error) {
                console.error("Error loading states:", error);
                stateSelect.innerHTML =
                    '<option value="">Error loading</option>';
            }
        } else {
            stateSelect.innerHTML = '<option value="">Select</option>';
        }
    },

    async updateCities(select, id) {
        const stateId = select.value;
        const citySelect = document.getElementById(`${id}-city`);
        citySelect.innerHTML = '<option value="">Loading...</option>';
        if (stateId) {
            try {
                const res = await fetch(`/locations?state_id=${stateId}`);
                const cities = await res.json();

                citySelect.innerHTML = '<option value="">Select</option>';
                cities.forEach((city) => {
                    citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            } catch (error) {
                console.error("Error loading cities:", error);
                citySelect.innerHTML =
                    '<option value="">Error loading</option>';
            }
        } else {
            citySelect.innerHTML = '<option value="">Select</option>';
        }
    },

    async init() {
        document.querySelectorAll(".parent-hide").forEach((el) => {
            el.style.display = "none";
        });
        await this.loadLocations();
        this.addParent();
        this.addChild();
    },

    async submitParents() {
        const formData = new FormData();

        for (let i = 1; i <= this.parentId; i++) {
            const el = document.getElementById(`p${i}`);
            if (el) {
                const inputs = el.querySelectorAll("input, select");

                // Add text data
                formData.append(`first_name`, inputs[0].value);
                formData.append(`last_name`, inputs[1].value);
                formData.append(`email`, inputs[2].value);
                formData.append(`country_id`, inputs[3].value);
                formData.append(`birth_date`, inputs[4].value);
                formData.append(`age`, inputs[5].value);
                formData.append(`state_id`, inputs[6].value);
                formData.append(`city_id`, inputs[7].value);
                formData.append(`education`, inputs[8].value);
                formData.append(`occupation`, inputs[9].value);

                // Add children relationships
                const selectedChildren = $(`#p${i}-children`).val();
                if (selectedChildren) {
                    selectedChildren.forEach((childId, index) => {
                        formData.append(`children[${index}]`, childId);
                    });
                }

                // Add residential proof files (multiple)
                if (this.files[`p${i}-docs`]) {
                    this.files[`p${i}-docs`].forEach((file, index) => {
                        formData.append(`residential_proof[${index}]`, file);
                    });
                }

                // Add profile image (single)
                const profileInput = document.getElementById(`p${i}-profile`);
                if (profileInput && profileInput.files[0]) {
                    formData.append(
                        `parents[${i}][profile_image]`,
                        profileInput.files[0]
                    );
                }
            }
        }

        try {
            const response = await fetch("store", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                console.log("Parents submitted:", result);
                console.log(result.data.id);
                const parentInput =
                    document.getElementsByClassName("parent-id");
                parentInput.value = result.data.id;
                document.querySelectorAll(".parent-hide").forEach((el) => {
                    el.style.display = "none"; // hide
                });

                document.querySelectorAll(".children-hide").forEach((el) => {
                    el.style.display = "block";
                });
                showToast("Parents Data submitted");
                showToast("Please fill the child form");
            } else {
                showToast(
                    "Error: " + (result.message || "Unknown error"),
                    "error"
                );
            }
        } catch (error) {
            console.error("Error submitting parents:", error);
            showToast("Error submitting parents. Please try again.", "error");
        }
    },

    submitChildren() {
        const children = [];
        for (let i = 1; i <= this.childId; i++) {
            const el = document.getElementById(`c${i}`);
            const parentIdChild = document.querySelector(".parent-id");
            if (el) {
                const inputs = el.querySelectorAll("input, select");
                const data = {
                    id: i,
                    first_name: inputs[0].value,
                    last_name: inputs[1].value,
                    email: inputs[2].value,
                    birth_date: inputs[3].value,
                    country_id: inputs[4].value,
                    state_id: inputs[5].value,
                    city_id: inputs[6].value,
                    parent_id: parentIdChild.value,
                };
                children.push(data);
            }
        }
        console.log("Children Data:", children);
        alert("Children submitted! Check console for data.");
    },

    async submitChildren() {
        const formData = new FormData();

        for (let i = 1; i <= this.childId; i++) {
            const el = document.getElementById(`c${i}`);
            if (el) {
                const inputs = el.querySelectorAll("input, select");

                formData.append(`first_name`, inputs[0].value);
                formData.append(`last_name`, inputs[1].value);
                formData.append(`email`, inputs[2].value);
                formData.append(`birth_date`, inputs[3].value);
                formData.append(`country_id`, inputs[4].value);
                formData.append(`state_id`, inputs[5].value);
                formData.append(`city_id`, inputs[6].value);


                // Add text data
                // formData.append(`children[${i}][firstName]`, inputs[0].value);
                // formData.append(`children[${i}][lastName]`, inputs[1].value);
                // formData.append(`children[${i}][email]`, inputs[2].value);
                // formData.append(`children[${i}][birthDate]`, inputs[3].value);
                // formData.append(`children[${i}][country]`, inputs[4].value);
                // formData.append(`children[${i}][state]`, inputs[5].value);
                // formData.append(`children[${i}][city]`, inputs[6].value);

                // Add parent relationships
                const selectedParents = $(`#c${i}-parents`).val();
                if (selectedParents) {
                    selectedParents.forEach((parentId, index) => {
                        formData.append(
                            `parents_ids[${index}]`,
                            parentId
                        );
                    });
                }

                // // Add submitted parent IDs
                // if (this.submittedParents) {
                //     this.submittedParents.forEach((parent, index) => {
                //         formData.append(
                //             `children[${i}][parent_ids][${index}]`,
                //             parent.id
                //         );
                //     });
                // }

                // Add birth certificate file (single)
                if (this.files[`c${i}-cert`] && this.files[`c${i}-cert`][0]) {
                    formData.append(
                        `birth_certificate`,
                        this.files[`c${i}-cert`][0]
                    );
                }
            }
        }

        try {
            const response = await fetch("store", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                console.log("Children submitted:", result);
                showToast("Children submitted successfully!");
            } else {
                showToast("Error: " + (result.message || "Unknown error"), "error");
            }
        } catch (error) {
            console.error("Error submitting children:", error);
            showToast("Error submitting children. Please try again.", "error");
        }
    },

    addParent() {
        const id = ++this.parentId;
        const html = `
                    <div class="person" id="p${id}">
                        ${
                            id > 1
                                ? `<button type="button" class="btn btn-danger btn-sm btn-remove" onclick="app.removeParent(${id})"><i class="fas fa-trash"></i></button>`
                                : ""
                        }
                        <h6 class="mb-3"><span class="badge-num">${id}</span> Parent ${id}</h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name *</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country *</label>
                                <select class="form-select" id="p${id}-country" required>
                                    <option value="">Select</option>
                                    ${this.countries
                                        .map(
                                            (c) =>
                                                `<option value="${c.id}">${c.name}</option>`
                                        )
                                        .join("")}
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Birth Date *</label>
                                <input type="date" class="form-control" onchange="app.calcAge(this, 'p${id}')" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Age</label>
                                <input type="number" class="form-control" id="p${id}-age" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">State *</label>
                               <select class="form-select" id="p${id}-state" onchange="app.updateCities(this, 'p${id}')" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">City *</label>
                                <select class="form-select" id="p${id}-city" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Education</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Occupation</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Residential Proof</label>
                                <div class="file-area">
                                    <input type="file" multiple accept=".pdf,.jpg,.jpeg,.png" onchange="app.handleFiles('p${id}-docs', this)">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-primary"></i>
                                    <div><small>Upload files</small></div>
                                </div>
                                <div class="file-list" id="p${id}-docs-list"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Profile Image</label>
                                <div class="file-area">
                                    <input type="file" accept="image/*" onchange="app.handleImage('p${id}-img', this)">
                                    <i class="fas fa-camera fa-2x text-primary"></i>
                                    <div><small>Upload photo</small></div>
                                </div>
                                <img id="p${id}-img" class="img-preview" style="display:none">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Children</label>
                                <select class="form-select select2" id="p${id}-children" multiple></select>
                            </div>
                        </div>
                    </div>
                `;
        document
            .getElementById("parentList")
            .insertAdjacentHTML("beforeend", html);
        this.updateSelects();
        fetchChildParent(id);
        const self = this; // or const self = app;
        document
            .getElementById(`p${id}-country`)
            .addEventListener("change", async function () {
                await self.updateStates(this, `p${id}`);
            });
    },

    removeParent(id) {
        document.getElementById(`p${id}`).remove();
        this.updateSelects();
    },

    addChild() {
        const id = ++this.childId;
        const html = `
                    <div class="person" id="c${id}">
                        ${
                            id > 1
                                ? `<button type="button" class="btn btn-danger btn-sm btn-remove" onclick="app.removeChild(${id})"><i class="fas fa-trash"></i></button>`
                                : ""
                        }
                        <h6 class="mb-3"><span class="badge-num">${id}</span> Child ${id}</h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name *</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Birth Date *</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Country *</label>
                                <select class="form-select" id="c${id}-country" required>
                                    <option value="">Select</option>
                                    ${this.countries
                                        .map(
                                            (c) =>
                                                `<option value="${c.id}">${c.name}</option>`
                                        )
                                        .join("")}
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State *</label>
                                <select class="form-select" id="c${id}-state" onchange="app.updateCities(this, 'c${id}')" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City *</label>
                                 <select class="form-select" id="c${id}-city" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Birth Certificate</label>
                                <div class="file-area">
                                    <input type="file" accept=".pdf,.jpg,.jpeg,.png" onchange="app.handleFiles('c${id}-cert', this)">
                                    <i class="fas fa-file-upload fa-2x text-primary"></i>
                                    <div><small>Upload certificate</small></div>
                                </div>
                                <div class="file-list" id="c${id}-cert-list"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Parents</label>
                                <select class="form-select select2" id="c${id}-parents" multiple></select>
                            </div>
                        </div>
                    </div>
                `;
        document
            .getElementById("childList")
            .insertAdjacentHTML("beforeend", html);
        this.updateSelects();
        fetchChildParent(id);
        // Country -> State
        document.getElementById(`c${id}-country`).addEventListener("change", async (event) => {

            await this.updateStates(event.target, `c${id}`);
        });

        // State -> City
        document.getElementById(`c${id}-state`).addEventListener("change", async (event) => {
            await this.updateCities(event.target, `c${id}`);
        });

    },

    removeChild(id) {
        document.getElementById(`c${id}`).remove();
        this.updateSelects();
    },

    calcAge(input, id) {
        const birth = new Date(input.value);
        const today = new Date();
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        document.getElementById(`${id}-age`).value = age >= 0 ? age : "";
    },

    handleFiles(key, input) {
        this.files[key] = Array.from(input.files);
        const list = document.getElementById(`${key}-list`);
        list.innerHTML = "";
        this.files[key].forEach((file, i) => {
            list.innerHTML += `
                        <div class="file-item">
                            <i class="fas fa-file"></i>
                            <span>${file.name.substring(0, 20)}${
                file.name.length > 20 ? "..." : ""
            }</span>
                            <button type="button" class="btn-del" onclick="app.removeFile('${key}', ${i})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
        });
    },

    removeFile(key, index) {
        this.files[key].splice(index, 1);
        const list = document.getElementById(`${key}-list`);
        list.innerHTML = "";
        this.files[key].forEach((file, i) => {
            list.innerHTML += `
                        <div class="file-item">
                            <i class="fas fa-file"></i>
                            <span>${file.name.substring(0, 20)}${
                file.name.length > 20 ? "..." : ""
            }</span>
                            <button type="button" class="btn-del" onclick="app.removeFile('${key}', ${i})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
        });
    },

    handleImage(id, input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.getElementById(id);
                img.src = e.target.result;
                img.style.display = "block";
            };
            reader.readAsDataURL(input.files[0]);
        }
    },

    updateSelects() {
        // Update children selects
        const childOpts = [];
        for (let i = 1; i <= this.childId; i++) {
            if (document.getElementById(`c${i}`)) {
                childOpts.push({ id: `c${i}`, text: `Child ${i}` });
            }
        }
        $(".select2")
            .filter('[id$="-children"]')
            .each(function () {
                const val = $(this).val();
                $(this).empty();
                childOpts.forEach((opt) =>
                    $(this).append(new Option(opt.text, opt.id))
                );
                if (val) $(this).val(val).trigger("change");
            });

        // Update parent selects
        const parentOpts = [];
        for (let i = 1; i <= this.parentId; i++) {
            if (document.getElementById(`p${i}`)) {
                parentOpts.push({ id: `p${i}`, text: `Parent ${i}` });
            }
        }
        $(".select2")
            .filter('[id$="-parents"]')
            .each(function () {
                const val = $(this).val();
                $(this).empty();
                parentOpts.forEach((opt) =>
                    $(this).append(new Option(opt.text, opt.id))
                );
                if (val) $(this).val(val).trigger("change");
            });
    },
};

app.init();
