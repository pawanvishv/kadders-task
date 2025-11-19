<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Registration Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
        }
        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
            padding: 30px 0;
        }
        .container-main { max-width: 1400px; }
        .header {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 32px;
            font-weight: bold;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }
        .sections {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 30px;
        }
        .section-title {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .person {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f8f9fa;
            position: relative;
        }
        .person:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }
        .badge-num {
            background: var(--primary);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }
        .btn-remove {
            position: absolute;
            top: 12px;
            right: 12px;
        }
        .btn-add {
            border: 2px dashed var(--primary);
            background: transparent;
            color: var(--primary);
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
        }
        .btn-add:hover {
            background: var(--primary);
            color: white;
        }
        .file-area {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background: white;
            position: relative;
            cursor: pointer;
        }
        .file-area:hover {
            border-color: var(--primary);
            background: #f8f9ff;
        }
        .file-area input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
        }
        .file-list {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .file-item {
            background: #e9ecef;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .file-item .btn-del {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 0;
        }
        .img-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 10px;
            border: 2px solid #e9ecef;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 13px;
            margin-bottom: 6px;
        }
        .form-control, .form-select {
            border-radius: 6px;
            border: 2px solid #e9ecef;
            padding: 8px 12px;
            font-size: 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .select2-container--default .select2-selection--multiple {
            border: 2px solid #e9ecef;
            border-radius: 6px;
            min-height: 38px;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--primary);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--primary);
            border: none;
            color: white;
        }
        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 12px 40px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container-fluid container-main">
        <div class="header">
            <h1>Family Registration</h1>
            <p class="text-muted mb-0">Complete the form below</p>
        </div>

        <form id="mainForm">
            <div class="sections">
                <div>
                    <div class="card">
                        <div class="section-title">
                            <i class="fas fa-users fa-lg"></i>
                            <h2 class="h5 mb-0">Parents Information</h2>
                        </div>
                        <div id="parentList"></div>
                        <button type="button" class="btn btn-add" onclick="app.addParent()">
                            <i class="fas fa-plus-circle me-2"></i>Add Another Parent
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary btn-lg btn-submit" onclick="app.submitParents()">
                            <i class="fas fa-check-circle me-2"></i>Submit Parents
                        </button>
                    </div>
                </div>

                <div>
                    <div class="card">
                        <div class="section-title">
                            <i class="fas fa-child fa-lg"></i>
                            <h2 class="h5 mb-0">Children Information</h2>
                        </div>
                        <div id="childList"></div>
                        <button type="button" class="btn btn-add" onclick="app.addChild()">
                            <i class="fas fa-plus-circle me-2"></i>Add Another Child
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-success btn-lg btn-submit" onclick="app.submitChildren()">
                            <i class="fas fa-check-circle me-2"></i>Submit Children
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script>
        const app = {
            parentId: 0,
            childId: 0,
            files: {},

            locations: {
                countries: {
                    'USA': ['California', 'Texas', 'New York', 'Florida'],
                    'India': ['Maharashtra', 'Karnataka', 'Delhi', 'Tamil Nadu'],
                    'UK': ['England', 'Scotland', 'Wales', 'Northern Ireland'],
                    'Canada': ['Ontario', 'Quebec', 'British Columbia', 'Alberta']
                },
                cities: {
                    'California': ['Los Angeles', 'San Francisco', 'San Diego'],
                    'Texas': ['Houston', 'Dallas', 'Austin'],
                    'New York': ['New York City', 'Buffalo', 'Rochester'],
                    'Maharashtra': ['Mumbai', 'Pune', 'Nagpur'],
                    'Karnataka': ['Bangalore', 'Mysore', 'Mangalore'],
                    'Delhi': ['New Delhi', 'Dwarka', 'Rohini'],
                    'England': ['London', 'Manchester', 'Birmingham'],
                    'Scotland': ['Edinburgh', 'Glasgow', 'Aberdeen'],
                    'Ontario': ['Toronto', 'Ottawa', 'Mississauga'],
                    'Quebec': ['Montreal', 'Quebec City', 'Laval']
                }
            },

            init() {
                this.addParent();
                this.addChild();
            },

            submitParents() {
                const parents = [];
                for (let i = 1; i <= this.parentId; i++) {
                    const el = document.getElementById(`p${i}`);
                    if (el) {
                        const inputs = el.querySelectorAll('input, select');
                        const data = {
                            id: i,
                            firstName: inputs[0].value,
                            lastName: inputs[1].value,
                            email: inputs[2].value,
                            country: inputs[3].value,
                            birthDate: inputs[4].value,
                            age: inputs[5].value,
                            state: inputs[6].value,
                            city: inputs[7].value,
                            education: inputs[8].value,
                            occupation: inputs[9].value,
                            children: $(`#p${i}-children`).val()
                        };
                        parents.push(data);
                    }
                }
                console.log('Parents Data:', parents);
                alert('Parents submitted! Check console for data.');
            },

            submitChildren() {
                const children = [];
                for (let i = 1; i <= this.childId; i++) {
                    const el = document.getElementById(`c${i}`);
                    if (el) {
                        const inputs = el.querySelectorAll('input, select');
                        const data = {
                            id: i,
                            firstName: inputs[0].value,
                            lastName: inputs[1].value,
                            email: inputs[2].value,
                            birthDate: inputs[3].value,
                            country: inputs[4].value,
                            state: inputs[5].value,
                            city: inputs[6].value,
                            parents: $(`#c${i}-parents`).val()
                        };
                        children.push(data);
                    }
                }
                console.log('Children Data:', children);
                alert('Children submitted! Check console for data.');
            },

            addParent() {
                const id = ++this.parentId;
                const html = `
                    <div class="person" id="p${id}">
                        ${id > 1 ? `<button type="button" class="btn btn-danger btn-sm btn-remove" onclick="app.removeParent(${id})"><i class="fas fa-trash"></i></button>` : ''}
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
                                <select class="form-select" onchange="app.updateStates(this, 'p${id}')" required>
                                    <option value="">Select</option>
                                    ${Object.keys(this.locations.countries).map(c => `<option value="${c}">${c}</option>`).join('')}
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
                document.getElementById('parentList').insertAdjacentHTML('beforeend', html);
                $(`#p${id}-children`).select2({ placeholder: 'Select children', width: '100%' });
                this.updateSelects();
            },

            removeParent(id) {
                $(`#p${id}-children`).select2('destroy');
                document.getElementById(`p${id}`).remove();
                this.updateSelects();
            },

            addChild() {
                const id = ++this.childId;
                const html = `
                    <div class="person" id="c${id}">
                        ${id > 1 ? `<button type="button" class="btn btn-danger btn-sm btn-remove" onclick="app.removeChild(${id})"><i class="fas fa-trash"></i></button>` : ''}
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
                                <select class="form-select" onchange="app.updateStates(this, 'c${id}')" required>
                                    <option value="">Select</option>
                                    ${Object.keys(this.locations.countries).map(c => `<option value="${c}">${c}</option>`).join('')}
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
                document.getElementById('childList').insertAdjacentHTML('beforeend', html);
                $(`#c${id}-parents`).select2({ placeholder: 'Select parents', width: '100%' });
                this.updateSelects();
            },

            removeChild(id) {
                $(`#c${id}-parents`).select2('destroy');
                document.getElementById(`c${id}`).remove();
                this.updateSelects();
            },

            updateStates(select, id) {
                const country = select.value;
                const stateSelect = document.getElementById(`${id}-state`);
                const citySelect = document.getElementById(`${id}-city`);
                stateSelect.innerHTML = '<option value="">Select</option>';
                citySelect.innerHTML = '<option value="">Select</option>';
                if (country && this.locations.countries[country]) {
                    this.locations.countries[country].forEach(state => {
                        stateSelect.innerHTML += `<option value="${state}">${state}</option>`;
                    });
                }
            },

            updateCities(select, id) {
                const state = select.value;
                const citySelect = document.getElementById(`${id}-city`);
                citySelect.innerHTML = '<option value="">Select</option>';
                if (state && this.locations.cities[state]) {
                    this.locations.cities[state].forEach(city => {
                        citySelect.innerHTML += `<option value="${city}">${city}</option>`;
                    });
                }
            },

            calcAge(input, id) {
                const birth = new Date(input.value);
                const today = new Date();
                let age = today.getFullYear() - birth.getFullYear();
                const m = today.getMonth() - birth.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
                document.getElementById(`${id}-age`).value = age >= 0 ? age : '';
            },

            handleFiles(key, input) {
                this.files[key] = Array.from(input.files);
                const list = document.getElementById(`${key}-list`);
                list.innerHTML = '';
                this.files[key].forEach((file, i) => {
                    list.innerHTML += `
                        <div class="file-item">
                            <i class="fas fa-file"></i>
                            <span>${file.name.substring(0, 20)}${file.name.length > 20 ? '...' : ''}</span>
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
                list.innerHTML = '';
                this.files[key].forEach((file, i) => {
                    list.innerHTML += `
                        <div class="file-item">
                            <i class="fas fa-file"></i>
                            <span>${file.name.substring(0, 20)}${file.name.length > 20 ? '...' : ''}</span>
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
                        img.style.display = 'block';
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
                $('.select2').filter('[id$="-children"]').each(function() {
                    const val = $(this).val();
                    $(this).empty();
                    childOpts.forEach(opt => $(this).append(new Option(opt.text, opt.id)));
                    if (val) $(this).val(val).trigger('change');
                });

                // Update parent selects
                const parentOpts = [];
                for (let i = 1; i <= this.parentId; i++) {
                    if (document.getElementById(`p${i}`)) {
                        parentOpts.push({ id: `p${i}`, text: `Parent ${i}` });
                    }
                }
                $('.select2').filter('[id$="-parents"]').each(function() {
                    const val = $(this).val();
                    $(this).empty();
                    parentOpts.forEach(opt => $(this).append(new Option(opt.text, opt.id)));
                    if (val) $(this).val(val).trigger('change');
                });
            }
        };

        app.init();
    </script>
</body>
</html>
