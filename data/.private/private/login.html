<div
    class="h-auto w-full flex fixed top-12 items-center justify-center flex-col p-4 space-y-2 z-40"
>
    <div
        id="msg"
        class="text-center text-md font-bold w-auto ring-0 ring-blue-500 rounded-xl shadow-xl mt-4 p-4 backdrop-blur-md transition transition-all ease-in-out duration-500 opacity-0 scale-0"
    >
        <label>Loading...</label>
    </div>
</div>
<main class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="md:h-screen md:flex md:flex-col md:place-content-center">
        <div
            class="text-center text-md lg:text-lg xl:text-xl p-2 border-blue-500 border-solid rounded-xl m-3 mt-2 mb-10"
        >
            <label class="font-bold"
                >All new users will get an extra
                <b class="text-green-500">$100 </b>credit</label
            >
        </div>
        <!--<div class="hidden text-center text-md p-2 text-red-500 m-3 rounded-xl bg-red-500 text-white p-4 transition-all transition-discrete opacity-0 ease-in-out" id="messages"><label class="font-bold"></label></div>-->
        <h2 class="text-2xl lg:text-4xl font-bold text-gray-900 mb-1 text-center">
            Log in or Sign up
        </h2>
        <div class="text-center mb-4 text-md lg:text-lg xl:text-xl p-2">
            <label class="font-bold">Join us and start your journey!</label>
        </div>
        <div class="space-y-4 my-14">
            <div class="w-full flex items-center justify-center">
                <input
                    type="text"
                    name="clientid"
                    id="clientid"
                    placeholder="ClientID"
                    required=""
                    class="block w-64 sm:w-80 md:w-96 lg:w-96 xl:w-96 text-center sm:h-10 lg:h-16 px-3 py-1.5 text-sm lg:text-lg bg-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                />
            </div>
            <div class="w-full flex items-center justify-center">
                <input
                    type="password"
                    name="password"
                    id="clientpassword"
                    placeholder="Password >=6 characters long"
                    required=""
                    class="block text-center w-64 sm:w-80 md:w-96 lg:w-96 xl:w-96 sm:h-10 lg:h-16 px-3 py-1.5 text-sm bg-gray-200 lg:text-lg rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                />
            </div>
            <div class="text-center w-full flex items-center justify-center">
                <button
                    style=""
                    class="loginbtn w-64 sm:w-auto lg:text-lg my-8 shadow-sm disabled:bg-amber-700"
                    id="lgn"
                    name="login"
                >
                    LOGIN
                </button>
            </div>
        </div>
    </div>
</main>
<div id="novelModal" class="modal-overlay">
    <div class="modal-content backdrop-blur-sm">
        <button
            id="modalCloseButton"
            class="modal-close-button"
            aria-label="Close modal"
        >
            &times;
        </button>
        <div class="p-5">
            <h2 id="modalTitle" class="text-2xl font-bold text-gray-900 mb-5">
                Error
            </h2>
            <h4
                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1"
            >
                Description
            </h4>
            <p
                id="modalDescription"
                class="text-sm text-gray-700 leading-relaxed mb-4 max-h-40 overflow-y-auto"
            >
                Something went wrong
            </p>
        </div>
    </div>
</div>
<script>
    const msg = document.getElementById("msg");
    const clientid = document.getElementById("clientid");
    const passwd = document.getElementById("clientpassword");
    const loginbtn = document.getElementById("lgn");
    const modal = document.getElementById("novelModal");
    const modalCloseButton = document.getElementById("modalCloseButton");
    const modalTitle = document.getElementById("modalTitle");
    const modalDescription = document.getElementById("modalDescription");
    loginbtn.addEventListener("click", async function () {
        msg.classList.add("opacity-0", "scale-0");
        msg.classList.remove("bg-white/30", "opacity-100", "scale-100");

        const emailValue = clientid.value;
        const pass = passwd.value;
        if (pass.length < 6) {
            passwd.classList.remove("bg-gray-200");
            passwd.classList.add("bg-red-200", "ring-red-500", "ring-2");
            return;
        }
        // Reset styling
        clientid.classList.remove("bg-red-200", "ring-red-500", "ring-2");
        clientid.classList.add("bg-gray-200");
        passwd.classList.remove("bg-red-200", "ring-red-500", "ring-2");
        passwd.classList.add("bg-gray-200");

        // Prepare data to send, including our 'action' signal
        const formData = new FormData();
        formData.append("login", "");
        formData.append("clientid", emailValue);
        formData.append("password", pass);
        msg.classList.remove("opacity-0", "scale-0");
        msg.classList.add("bg-white/30", "opacity-100", "scale-100");
        await fetch("", {
            method: "POST",
            body: formData
        })
        //debug by showing raw response
        /*.then(response => response.text())
        .then(data => {
            modalTitle. textContent = "Response";

modalDescription. textContent = data;

document.body.classList.add("modal-open");

modal.classList.add("active");

msg.classList.add("opacity-0", "scale-0");

msg.classList.remove("bg-white/30", "opacity-100", "scale-100");
        })*/
            .then(response => response.json())
            .then(data => {
                if (data.code === 0x1) {
                    // Add error classes based on the JSON response
                    clientid.classList.remove("bg-gray-200");
                    clientid.classList.add(
                        "bg-red-200",
                        "ring-red-500",
                        "ring-2"
                    );
                } else if (data.code === 0x2) {
                    passwd.classList.remove("bg-gray-200");
                    passwd.classList.add(
                        "bg-red-200",
                        "ring-red-500",
                        "ring-2"
                    );
                } else {
                    modalTitle.textContent = "Error: " + data.code;
                    modalDescription.textContent = data.msg;
                    document.body.classList.add("modal-open");
                    modal.classList.add("active");
                }
                msg.classList.add("opacity-0", "scale-0");
                msg.classList.remove("bg-white/30", "opacity-100", "scale-100");
            })
            .catch(error => {
                modalTitle.textContent = "Error";
                modalDescription.textContent = error;
                document.body.classList.add("modal-open");
                modal.classList.add("active");
                msg.classList.add("opacity-0", "scale-0");
                msg.classList.remove("bg-white/30", "opacity-100", "scale-100");
            });
    });
    function closeModal() {
        document.body.classList.remove("modal-open");
        modal.classList.remove("active");
    }

    modalCloseButton.addEventListener("click", closeModal);
    modal.addEventListener("click", event => {
        if (event.target === modal) {
            closeModal();
        }
    });
</script>
