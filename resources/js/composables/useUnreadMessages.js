import { ref } from 'vue';
import axios from 'axios';

const unreadCount = ref(0);

const fetchUnreadCount = async () => {
    try {
        const { data } = await axios.get('/admin/data/messages/unread-count');
        unreadCount.value = data.count;
    } catch (error) {
        console.error('Unable to load unread count:', error);
    }
};

export function useUnreadMessages() {
    return { unreadCount, fetchUnreadCount };
}