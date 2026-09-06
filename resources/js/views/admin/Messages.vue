<template>

    <AdminLayout>

        <!-- Page Header -->

        <div class="page-header">

            <div>
                <h4>Messages</h4>
                <p>View messages received from your portfolio website.</p>
            </div>

        </div>


        <!-- Messages -->

        <div class="content-card">

            <div class="card-header-custom">

                <div>
                    <h6>Contact Messages</h6>
                    <span>
                        {{ messages.length }} total messages
                    </span>
                </div>

            </div>


            <div v-if="loading" class="loading">
                Loading messages...
            </div>


            <div v-else-if="messages.length === 0" class="empty-state">

                <i class="bi bi-envelope-open"></i>

                <h6>No messages yet</h6>

                <p>
                    Messages submitted from your contact form will appear here.
                </p>

            </div>


            <div v-else class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>
                            <th>Sender</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr
                            v-for="message in messages"
                            :key="message.id"
                            :class="{ 'unread-row': !message.is_read }"
                        >

                            <td>

                                <div class="sender">

                                    <div class="sender-avatar">
                                        {{ message.name.charAt(0).toUpperCase() }}
                                    </div>

                                    <div>

                                        <strong>
                                            {{ message.name }}
                                        </strong>

                                        <small>
                                            {{ message.email }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <strong class="subject">
                                    {{ message.subject || 'No subject' }}
                                </strong>

                            </td>


                            <td>

                                <span class="message-preview">
                                    {{ truncate(message.message, 60) }}
                                </span>

                            </td>


                            <td>

                                <span
                                    class="status"
                                    :class="message.is_read ? 'read' : 'unread'"
                                >
                                    {{ message.is_read ? 'Read' : 'Unread' }}
                                </span>

                            </td>


                            <td>

                                <span class="date">
                                    {{ formatDate(message.created_at) }}
                                </span>

                            </td>


                            <td class="text-end">

                                <button
                                    class="action-btn"
                                    title="View"
                                    @click="viewMessage(message)"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>


                                <button
                                    v-if="!message.is_read"
                                    class="action-btn"
                                    title="Mark as read"
                                    @click="markAsRead(message)"
                                >
                                    <i class="bi bi-envelope-open"></i>
                                </button>


                                <button
                                    class="action-btn delete"
                                    title="Delete"
                                    @click="deleteMessage(message.id)"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- Message Modal -->

        <div
            class="modal fade"
            id="messageModal"
            tabindex="-1"
            aria-hidden="true"
        >

            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <div>

                            <h5 class="modal-title">
                                {{ selectedMessage?.subject || 'Message' }}
                            </h5>

                            <small class="modal-date">
                                {{ selectedMessage ? formatDate(selectedMessage.created_at) : '' }}
                            </small>

                        </div>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>

                    </div>


                    <div class="modal-body" v-if="selectedMessage">

                        <div class="sender-details">

                            <div class="sender-avatar large">
                                {{ selectedMessage.name.charAt(0).toUpperCase() }}
                            </div>

                            <div>

                                <strong>
                                    {{ selectedMessage.name }}
                                </strong>

                                <a :href="`mailto:${selectedMessage.email}`">
                                    {{ selectedMessage.email }}
                                </a>

                            </div>

                        </div>


                        <div class="message-body">

                            <label>Message</label>

                            <p>
                                {{ selectedMessage.message }}
                            </p>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>

                        <a
                            v-if="selectedMessage"
                            :href="`mailto:${selectedMessage.email}`"
                            class="btn btn-dark"
                        >
                            <i class="bi bi-reply me-2"></i>
                            Reply
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>


<script setup>

import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Modal } from 'bootstrap';
import AdminLayout from '../../layouts/AdminLayout.vue';


const messages = ref([]);
const selectedMessage = ref(null);
const loading = ref(true);

let modal = null;


const loadMessages = async () => {

    try {

        loading.value = true;

        const response = await axios.get('/admin/data/messages');

        messages.value = response.data.messages;

    } catch (error) {

        console.error('Failed to load messages:', error);

    } finally {

        loading.value = false;

    }

};


const viewMessage = async (message) => {

    try {

        const response = await axios.get(
            `/admin/data/messages/${message.id}`
        );

        selectedMessage.value = response.data.message;

        if (!selectedMessage.value.is_read) {

            await markAsRead(message, false);

            selectedMessage.value.is_read = true;

        }

        modal.show();

    } catch (error) {

        console.error('Failed to load message:', error);

    }

};


const markAsRead = async (message, reload = true) => {

    try {

        await axios.put(
            `/admin/data/messages/${message.id}/read`
        );

        message.is_read = true;

        if (reload) {
            await loadMessages();
        }

    } catch (error) {

        console.error('Failed to mark message as read:', error);

    }

};


const deleteMessage = async (id) => {

    if (!confirm('Are you sure you want to delete this message?')) {
        return;
    }

    try {

        await axios.delete(
            `/admin/data/messages/${id}`
        );

        messages.value = messages.value.filter(
            message => message.id !== id
        );

    } catch (error) {

        console.error('Failed to delete message:', error);

    }

};


const truncate = (text, length) => {

    if (!text) {
        return '';
    }

    return text.length > length
        ? text.substring(0, length) + '...'
        : text;

};


const formatDate = (date) => {

    if (!date) {
        return '';

    }

    return new Date(date).toLocaleDateString(
        'en-US',
        {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        }
    );

};


onMounted(() => {

    const modalElement = document.getElementById('messageModal');

    if (modalElement) {
        modal = new Modal(modalElement);
    }

    loadMessages();

});

</script>


<style scoped>

.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 25px;
}

.page-header h4 {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
    color: #202733;
}

.page-header p {
    margin: 5px 0 0;
    font-size: 13px;
    color: #8991a0;
}

.content-card {
    background: #ffffff;
    border: 1px solid #e9edf3;
    border-radius: 12px;
    overflow: hidden;
}

.card-header-custom {
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #edf0f4;
}

.card-header-custom h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #252b36;
}

.card-header-custom span {
    display: block;
    margin-top: 3px;
    font-size: 11px;
    color: #9299a6;
}

.table thead th {
    background: #fafbfc;
    border-bottom: 1px solid #edf0f4;
    color: #9299a6;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    white-space: nowrap;
}

.table tbody td {
    border-color: #f0f2f5;
    color: #697386;
    font-size: 12px;
}

.unread-row {
    background: #fafbfc;
}

.sender {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sender-avatar {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    background: #f1f3f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    color: #495057;
    flex-shrink: 0;
}

.sender-avatar.large {
    width: 45px;
    height: 45px;
    font-size: 15px;
}

.sender strong {
    display: block;
    font-size: 12px;
    color: #343a40;
}

.sender small {
    display: block;
    margin-top: 2px;
    font-size: 10px;
    color: #9299a6;
}

.subject {
    color: #343a40;
    font-size: 12px;
}

.message-preview {
    color: #7a8391;
    font-size: 11px;
}

.status {
    display: inline-block;
    padding: 5px 8px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
}

.status.read {
    background: #e9f7ef;
    color: #198754;
}

.status.unread {
    background: #fff4e5;
    color: #fd7e14;
}

.date {
    white-space: nowrap;
    font-size: 11px;
    color: #9299a6;
}

.action-btn {
    width: 30px;
    height: 30px;
    border: 0;
    background: transparent;
    color: #6c757d;
    border-radius: 6px;
    margin-left: 3px;
}

.action-btn:hover {
    background: #f1f3f5;
    color: #212529;
}

.action-btn.delete:hover {
    background: #fff0f0;
    color: #dc3545;
}

.loading {
    padding: 50px;
    text-align: center;
    color: #9299a6;
    font-size: 13px;
}

.empty-state {
    padding: 60px 20px;
    text-align: center;
}

.empty-state i {
    font-size: 35px;
    color: #adb5bd;
}

.empty-state h6 {
    margin: 12px 0 5px;
    color: #343a40;
}

.empty-state p {
    margin: 0;
    font-size: 12px;
    color: #9299a6;
}

.sender-details {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 20px;
    border-bottom: 1px solid #edf0f4;
}

.sender-details strong {
    display: block;
    font-size: 14px;
    color: #343a40;
}

.sender-details a {
    display: block;
    margin-top: 3px;
    font-size: 11px;
    color: #6c757d;
    text-decoration: none;
}

.message-body {
    padding-top: 20px;
}

.message-body label {
    display: block;
    margin-bottom: 8px;
    font-size: 11px;
    font-weight: 600;
    color: #9299a6;
    text-transform: uppercase;
}

.message-body p {
    margin: 0;
    white-space: pre-wrap;
    font-size: 13px;
    line-height: 1.7;
    color: #495057;
}

.modal-date {
    color: #9299a6;
    font-size: 10px;
}

</style>