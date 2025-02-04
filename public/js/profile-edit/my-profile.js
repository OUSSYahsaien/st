document.querySelectorAll('.item').forEach(item => {
    item.addEventListener('click', () => {
        // Remove active class from all nav items and content sections
        document.querySelectorAll('.item').forEach(nav => nav.classList.remove('active'));
        document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
        
        // Add active class to clicked nav item
        item.classList.add('active');
        
        // Show corresponding content section
        const sectionId = item.getAttribute('data-section');
        document.getElementById(sectionId).classList.add('active');
    });
});

document.querySelectorAll('.item').forEach(item => {
    item.addEventListener('click', () => {
        // Supprimer la classe active de tous les boutons et sections
        document.querySelectorAll('.item').forEach(nav => nav.classList.remove('active'));
        document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));

        // Ajouter la classe active au bouton cliqué
        item.classList.add('active');

        // Afficher la section correspondante
        const sectionId = item.getAttribute('data-section');
        document.getElementById(sectionId).classList.add('active');
    });
});





// const fileInput = document.getElementById('profile-upload-input');
// const profileImage = document.getElementById('profile-image');

// fileInput.addEventListener('change', async (event) => {
//     const file = event.target.files[0];

//     if (file && (file.type === 'image/png' || file.type === 'image/jpeg')) {
//         const formData = new FormData();
//         formData.append('profile_picture', file);

//         try {
//             const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//             const response = await fetch('/candidat/upload-profile-picture', {
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': csrfToken
//                 },
//                 body: formData
//             });

//             const result = await response.json();

//             if (result.success) {
//                 // Met à jour l'image affichée
//                 profileImage.src = result.filePath;
//                 alert('Image téléchargée avec succès!');
//             } else {
//                 alert('Une erreur est survenue lors du téléchargement.');
//             }
//         } catch (error) {
//             console.error('Erreur:', error);
//             alert('Une erreur est survenue lors de la requête.');
//         }
//     } else {
//         alert('Veuillez sélectionner une image au format PNG, JPG ou JPEG.');
//     }
// });



document.getElementById('profile-upload-input').addEventListener('change', function (event) {
    const reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById('profile-image').src = e.target.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});
