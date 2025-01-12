
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('addEmployeeForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); 

        
        const employerName = document.getElementById('employer_name').value.trim();
        const companyName = document.getElementById('company_name').value.trim();
        const contactNo = document.getElementById('contact_no').value.trim();
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

    
        if (employerName === '') {
            alert("Employer Name cannot be empty");
            return;
        }

        if (companyName === '') {
            alert("Company Name cannot be empty");
            return;
        }

        if (contactNo === '') {
            alert("Contact Number cannot be empty");
            return;
        }

        if (username === '') {
            alert("Username cannot be empty");
            return;
        }

        if (password === '') {
            alert("Password cannot be empty");
            return;
        }

      
        const formData = new FormData(form);

        fetch('../controller/add_employee_controller.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes('Error')) {
                alert('Something went wrong, please try again.');
            } else {
                alert('Employee added successfully!');
                window.location.href = '../view/show_employees_view.php'; // Redirect to the employee list
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the employee.');
        });
    });
});
