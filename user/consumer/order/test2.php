<style>
    .upload-grid {
    display: grid;
    grid-template-columns: repeat(5, 80px);
    gap: 10px;
}

.upload-box {
    width: 80px;
    height: 80px;
    border: 2px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 32px;
    color: #aaa;
    border-radius: 8px;
    position: relative;
    overflow: hidden;
}

.upload-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.upload-box.filled {
    border: none;
}

</style>
<form action="submit_review.php" method="POST" enctype="multipart/form-data">

    <div class="upload-grid">
        <!-- hidden file input -->
        <input type="file" id="imageInput" name="review_images[]" accept="image/*" multiple hidden>

        <!-- upload boxes -->
        <div class="upload-box" onclick="openPicker(0)"><span>+</span></div>
        <div class="upload-box" onclick="openPicker(1)"><span>+</span></div>
        <div class="upload-box" onclick="openPicker(2)"><span>+</span></div>
        <div class="upload-box" onclick="openPicker(3)"><span>+</span></div>
        <div class="upload-box" onclick="openPicker(4)"><span>+</span></div>
    </div>

    <button type="submit">Submit</button>
</form>

<script>
let selectedFiles = [];
const input = document.getElementById("imageInput");
const boxes = document.querySelectorAll(".upload-box");

function openPicker(index) {
    if (selectedFiles.length >= 5) return;

    input.click();

    input.onchange = () => {
        const file = input.files[0];
        if (!file) return;

        if (!file.type.startsWith("image/")) {
            alert("Only images allowed");
            return;
        }

        if (selectedFiles.length < 5) {
            selectedFiles.push(file);
            updateBoxes();
        }

        input.value = "";
    };
}

function updateBoxes() {
    boxes.forEach((box, index) => {
        box.innerHTML = "<span>+</span>";
        box.classList.remove("filled");

        if (selectedFiles[index]) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(selectedFiles[index]);
            box.innerHTML = "";
            box.appendChild(img);
            box.classList.add("filled");
        }
    });

    syncInputFiles();
}

// 🔑 Make PHP receive the files
function syncInputFiles() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
}
</script>
