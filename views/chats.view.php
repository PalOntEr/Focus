<?php
    require 'views/components/header.php';
?>
<div class="w-screen h-screen overflow-x-hidden">
<?php
    require 'views/components/navbar.php';
?>
<div class="container mx-auto flex flex-col sm:flex-row h-full w-screen mt-4">
    <div class="hidden sm:flex flex-col h-5/6 w-1/3 bg-primary rounded-xl mx-5 p-5">
        <div class="flex justify-between items-center mb-5 space-x-5">
            <h1 class="text-2xl text-color font-extrabold">Chats</h1>
            <select id="user" name="user" class="user mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                <option value="">Select an instructor</option>
            </select>
        </div>
        <div class="chatPreviewContainer flex flex-col space-y-2 overflow-y-scroll h-full rounded-xl">
        </div>
    </div>
    <div class="flex flex-col h-5/6 w-[90%] sm:w-2/3 bg-primary rounded-xl mb-5 sm:mb-0 mx-5 p-5">            
        <h1 class="flex text-2xl font-bold space-x-2 mb-5 items-center">
            <img class="h-10 w-10 rounded-full" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt="">
            <p id="currentReceiverName" class="text-color ">Selecciona un chat</p>
        </h1>
        <div id="chatMessagesContainer" class="flex flex-col space-y-2 overflow-y-scroll h-full p-2 rounded-xl">
        </div>
        <div class="flex flex-col justify-end bg-comp-2 p-2 rounded-xl mt-3 items-center">
            <div class="flex justify-between w-full space-x-2">
            <input id="message" type="text" class="w-full px-2 py-1 rounded-md" placeholder="Type a message...">
            <button onclick="sendMessage()" class="px-2 py-1 bg-secondary text-white rounded-md">Send</button>
            </div>
        </div>
    </div>
    <div class="flex sm:hidden flex-col h-5/6 w-[90%] bg-primary rounded-xl mx-5 p-5">
        <div class="flex justify-between items-center mb-5 space-x-5">
            <h1 class="text-2xl font-bold">Chats</h1>
            <select id="user" name="user" class="user mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                <option value="">Select an instructor</option>
            </select>
        </div>
        <div class="chatPreviewContainer flex flex-col space-y-2 overflow-y-scroll h-full rounded-xl">
        </div>
    </div>
</div>
</div>
<script>
    let currentReceiverId = <?= $_GET['insId'] ?? 0 ?>;
    const userId = <?= $_SESSION['user']['userId'] ?? 0 ?>;
    const chatPreviewContainer = document.querySelectorAll('.chatPreviewContainer');
    const uniqueChats = new Map();

    let users = {};

    document.addEventListener('DOMContentLoaded', async () => {
        
        try {
            
            fetch('/users')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    users = data.payload.users.reduce((acc, user) => {
                        acc[user.userId] = user;
                        return acc;
                    }, {});
                    const userSelector = document.querySelectorAll('.user');
                    data.payload.users.forEach(user => {
                        if (user.role === 'I' && user.userId !== userId) {
                            userSelector.forEach(selector => {
                                const option = document.createElement('option');
                                option.value = user.userId;
                                option.textContent = user.username;
                                selector.appendChild(option);
                            });
                        }
                    });
                    userSelector.forEach(selector => {
                        selector.addEventListener('change', () => {
                            if (selector.value === '' || parseInt(selector.value) === 0) {
                                return;
                            }
                            currentReceiverId = parseInt(selector.value);
                            getChats();
                        });
                    });
                    
                } else {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch users.',
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching users:', error);
                swal({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching users. Please try again later.',
                });
            });

            getChats();

        } catch (error) {
            console.error('Error fetching chats:', error);
        }
            
    });

    async function getChats(){
        const senderChats = await fetch(`/messages?get_chat=true&sender_id=${userId}`);
        const senderData = await senderChats.json();
        if (senderData.status) {
            const chats = senderData.payload.chats;
            chats.forEach(chat => {
                const otherUserId = chat.senderId === userId ? chat.receiverId : chat.senderId;
                if (!uniqueChats.has(otherUserId)) {
                    uniqueChats.set(otherUserId, chat);
                }
            });
        }
        const receiverChats = await fetch(`/messages?get_chat=false&sender_id=${userId}`);
        const receiverData = await receiverChats.json();
        
        if (receiverData.status) {
            const chats = receiverData.payload.chats;
            chats.forEach(chat => {
                const otherUserId = chat.senderId === userId ? chat.receiverId : chat.senderId;
                if (!uniqueChats.has(otherUserId)) {
                    uniqueChats.set(otherUserId, chat);
                }
            });
            chatPreviewContainer.forEach(container => container.innerHTML = '');
            uniqueChats.forEach(chat => {
                const otherUserId = chat.senderId === userId ? chat.receiverId : chat.senderId;
                const otherUserName = chat.senderId === userId ? chat.receiverUsername : chat.senderUsername;
                let chatPreview = `<?php require 'views/components/chatPreview.php'; ?>`;
                chatPreview = chatPreview.replace('Dobeto', otherUserName);
                chatPreview = chatPreview.replace('id="receiverID"', `id="receiverID-${otherUserId}"`);
                chatPreviewContainer.forEach(container => container.innerHTML += chatPreview);
            });
            
            if (currentReceiverId !== 0) {
                const existingChatPreview = document.getElementById(`receiverID-${currentReceiverId}`);
                if (!existingChatPreview) {
                    const otherUserId = currentReceiverId;
                    const otherUserName = users[otherUserId].username;
                    let chatPreview = `<?php require 'views/components/chatPreview.php'; ?>`;
                    chatPreview = chatPreview.replace('Dobeto', otherUserName);
                    chatPreview = chatPreview.replace('id="receiverID"', `id="receiverID-${otherUserId}"`);
                    chatPreviewContainer.forEach(container => container.innerHTML += chatPreview);
                }
            }
        }

        document.querySelectorAll('[id^="receiverID-"]').forEach(chatPreview => {
            chatPreview.addEventListener('click', () => {
            const currentReceiverName = document.getElementById('currentReceiverName');
            currentReceiverName.innerText = chatPreview.querySelector('.receiver-name').innerText;
            
            const receiverId = chatPreview.id.split('-')[1];
            currentReceiverId = receiverId;
            
            const chatMessagesContainer = document.getElementById('chatMessagesContainer');
                getChatMessages()
            });
        });

        if (currentReceiverId !== 0) {
            const existingChatPreview = document.getElementById(`receiverID-${currentReceiverId}`);
            existingChatPreview.click();
        }
    } 

    async function sendMessage(){
        
        if (!currentReceiverId || currentReceiverId === 0) {
            swal('🤡', 'Please select a user to chat with', 'error');
            return;
        }

        if (!document.getElementById('message').value || document.getElementById('message').value === '') {
            swal('🤔', 'Please type a message', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('sender_id', <?= $_SESSION['user']['userId'] ?? 0 ?>);
        formData.append('receiver_id', currentReceiverId);
        formData.append('message', document.getElementById('message').value);

        const response = await fetch('/messages', {
            method: 'POST',
            body: formData
        });

        if (response.status === 200) {
            // swal('🥳', 'Message sent successfully', 'success');
            const chatMessagesContainer = document.getElementById('chatMessagesContainer');
            const message = document.getElementById('message').value;
            const formattedTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            let outgoingMessage = `<?php require 'views/components/outgoingMessage.php'; ?>`;
            outgoingMessage = outgoingMessage.replace('Fine, and you?', message).replace('8:30pm', formattedTime);
            chatMessagesContainer.innerHTML += outgoingMessage;
            document.getElementById('message').value = '';
        } else {
            swal('☠️', 'Failed to send message', 'error');
        }
    }

    async function translateMessage(tag, message){
        const formData = new FormData();
        formData.append('text', message);

        tag.innerText = 'Translating...';

        const response = await fetch('/translate', {
            method: 'POST',
            body: formData
        });

        if (response.status === 200) {
            const data = await response.json();
            if (data.status) {
                tag.innerText = data.payload.translatedText;
            } else {
                swal('🤯', 'Failed to translate message', 'error');
            }
        } else {
            swal('😵‍💫', 'Failed to translate message', 'error');
        }
    }

    async function getChatMessages(){
            
        let incomingMessage = `<?php require 'views/components/incomingMessage.php'; ?>`;
        let outgoingMessage = `<?php require 'views/components/outgoingMessage.php'; ?>`;

        Promise.all([
            fetch(`/messages?receiver_id=${userId}&sender_id=${currentReceiverId}`).then(response => response.json()),
            fetch(`/messages?sender_id=${userId}&receiver_id=${currentReceiverId}`).then(response => response.json())
        ])
        .then(([receivedData, sentData]) => {
            if (receivedData.status && sentData.status) {
                const messages = [...receivedData.payload.messages, ...sentData.payload.messages];
                messages.sort((a, b) => new Date(a.creationDate) - new Date(b.creationDate));
                chatMessagesContainer.innerHTML = '';
                messages.forEach(message => {
                    const formattedTime = new Date(message.creationDate).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    const formattedMessage = (message.receiverId === userId)
                        ? incomingMessage.replace('Hello, how are you?', message.message).replace('8:30pm',  formattedTime)
                        : outgoingMessage.replace('Fine, and you?', message.message).replace('8:30pm',  formattedTime);
                    chatMessagesContainer.innerHTML += formattedMessage;
                });
                const translateBtns = document.querySelectorAll('.translate');
                translateBtns.forEach(translateBtn => {
                    translateBtn.addEventListener('click', () => {
                        translateMessage(translateBtn.parentElement.previousElementSibling, translateBtn.parentElement.previousElementSibling.innerText);
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
    }
</script>