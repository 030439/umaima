"use strict";



function fetchPermissions() {
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/permissions-listing')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const permissions = data.permissions;
                    const tableBody = document.querySelector('#permissionsTable tbody');
                    tableBody.innerHTML = ''; // Clear existing rows

                    // Group permissions by category
                    const categories = {};

                    permissions.forEach(permission => {
                        const [category, action] = permission.name.split('.');
                        if (!categories[category]) {
                            categories[category] = [];
                        }
                        categories[category].push({ ...permission, action });
                    });

                    // Iterate over each category and create a row for it
                    Object.keys(categories).forEach(category => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="text-nowrap fw-medium text-heading">${capitalize(category)}</td>
                            <td>
                                <div class="d-flex justify-content-start">
                                    <!-- Select All Checkbox -->
                                    <div class="form-check mb-0 me-4">
                                        <input class="form-check-input select-all-checkbox" type="checkbox" id="selectAll_${category}">
                                        <label class="form-check-label" for="selectAll_${category}">
                                             All
                                        </label>
                                    </div>

                                    <!-- Individual Permission Checkboxes -->
                                    ${categories[category].map(permission => `
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                            <input class="form-check-input permission-checkbox" type="checkbox" id="${permission.name}" name="permissions[]" value="${permission.id}">
                                            <label class="form-check-label" for="${permission.name}">
                                                ${capitalize(permission.action)}
                                            </label>
                                        </div>
                                    `).join('')}
                                </div>
                            </td>
                        `;
                        tableBody.appendChild(row);

                        // Add event listener for the "Select All" checkbox
                        const selectAllCheckbox = row.querySelector(`#selectAll_${category}`);
                        const permissionCheckboxes = row.querySelectorAll('.permission-checkbox');

                        selectAllCheckbox.addEventListener('change', function() {
                            permissionCheckboxes.forEach(checkbox => {
                                checkbox.checked = selectAllCheckbox.checked;
                            });
                        });
                    });
                } else {
                    console.error('Error fetching permissions:', data.message);
                }
            })
            .catch(error => console.error('Fetch error:', error));
    });
}

// Utility function to capitalize words
function capitalize(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

fetchPermissions();





