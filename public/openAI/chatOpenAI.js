document.addEventListener("DOMContentLoaded", function () {
    // Display the initial greeting from the server
    displayMessage(
        "system",
        "Having health issues? Describe how you are feeling lately."
    );

    // Create the spinner container
    // var spinnerContainer = createSpinnerContainer();

    // Append the spinner container to the parent of the user input element
    var userInputParent = document.getElementById("user-input").parentNode;
    // userInputParent.appendChild(spinnerContainer);
});

// Function to show loading spinner
function showLoadingSpinner() {
    // You can customize this logic based on your spinner implementation
    var spinnerContainer = document.getElementById("loading-spinner");
    var userInput = document.getElementById("user-input");
    if (spinnerContainer) {
        spinnerContainer.style.display = "flex";
        userInput.disabled = true;
    }
}

// Function to hide loading spinner
function hideLoadingSpinner() {
    // You can customize this logic based on your spinner implementation
    var spinnerContainer = document.getElementById("loading-spinner");
    var userInput = document.getElementById("user-input");
    if (spinnerContainer) {
        spinnerContainer.style.display = "none";
        userInput.disabled = false;
    }
}

// Function to send user message to the server
async function sendMessageToServer(userInput) {
    try {
        // Get CSRF token
        var csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        showLoadingSpinner();

        // Send user message to the server
        const response = await fetch("/fetch-response", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ userMessage: userInput }),
        });

        const data = await response.json();

        console.log("Received data from server:", data);

        if (data.response) {
            // Display the system's response based on the length
            if (data.response.length >= 3) {
                displayMessage("system", data.response[0]);
                displayMessage("system", data.response[1]);
                displayMessage("system", data.response[2]);
            } else if (data.response.length === 2) {
                displayMessage("system", data.response[0]);
                displayMessage("system", data.response[1]);
            } else if (data.response.length === 1) {
                displayMessage("system", data.response[0]);
            }

            // Activate and display the doctorList element
            var doctorListElement = document.getElementById("doctorList");
            if (doctorListElement) {
                doctorListElement.style.display = "block";
            }
        } else {
            console.error("Unexpected response format:", data);
        }
    } catch (error) {
        console.error("Error sending message to server:", error);
    } finally {
        // Hide loading spinner after receiving the server response
        hideLoadingSpinner();
    }
}

// Event listener for the send button
document.getElementById("send-button").addEventListener("click", function () {
    // Get user input
    var userInput = document.getElementById("user-input").value;

    // Check if the user input is not empty before proceeding
    if (userInput.trim() !== "") {
        // Display user message
        displayMessage("user", userInput);

        // Clear user input
        document.getElementById("user-input").value = "";

        // Send user message to the server
        sendMessageToServer(userInput);

        // Disable the send button again after processing the click
        this.disabled = true;
    }
});

// Event listener for modal buttons
var modalButtons = document.querySelectorAll("#keywordsModal button");
modalButtons.forEach(function (button) {
    button.addEventListener("click", function () {
        // Get the text content of the clicked button and set it as user input
        var keywordValue = button.textContent.trim();
        var userInput = `${keywordValue}`;

        // Check if the user input is not empty before proceeding
        if (userInput.trim() !== "") {
            // Display user message
            displayMessage("user", userInput);

            // Clear user input
            document.getElementById("user-input").value = "";

            // Send user message to the server
            sendMessageToServer(userInput);

            // Disable the send button again after processing the click
            document.getElementById("send-button").disabled = true;
        }
    });
});

// Attach the input validation and button disabling directly to the keyup event
document.getElementById("user-input").addEventListener("keyup", function (event) {
    var userInput = this.value.trim();
    var sendButton = document.getElementById("send-button");

    if (userInput !== "") {
        sendButton.disabled = false;
    } else {
        sendButton.disabled = true;
    }
    // Check if Enter key is pressed (key code 13)
    if (event.key === "Enter" && userInput !== "") {
        // Trigger the click event on the Send button
        document.getElementById("send-button").click();
    }
});

// The displayMessage function definition remains unchanged
// The displayMessage function definition
function displayMessage(role, message) {
    var chatContainer = document.getElementById("chat-container");
    var messageContainer = document.createElement("div");
    var loadingSpinner = document.createElement("div");
    messageContainer.classList.add("message-container");

    // Add a class based on the role to distinguish between user and system messages
    messageContainer.classList.add(
        role === "user" ? "user-message" : "system-message"
    );

    // Check if the message is defined before splitting
    if (message) {
        // Split the message into separate lines for system messages
        if (role === "system") {
            var lines = message.split("\n");
            lines.forEach((line) => {
                var messageElement = document.createElement("div");
                messageElement.innerHTML = line; // Use innerHTML instead of textContent
                messageContainer.appendChild(messageElement);
            });
        } else {
            // For user messages, just display the message as a single block
            messageContainer.innerHTML = message; // Use innerHTML instead of textContent
        }
    }

    chatContainer.appendChild(messageContainer);
}
