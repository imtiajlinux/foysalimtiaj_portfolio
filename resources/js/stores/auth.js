import { ref } from 'vue';

const user = ref(null);
const loading = ref(false);

export function useAuth() {

    const isAuthenticated = () => {
        return user.value !== null;
    };

    const fetchUser = async () => {

        loading.value = true;

        try {

            const response = await fetch('/admin/auth/user', {
                method: 'GET',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },

                credentials: 'same-origin',
            });

            if (!response.ok) {
                user.value = null;
                return false;
            }

            const data = await response.json();

            if (!data.authenticated || !data.user) {
                user.value = null;
                return false;
            }

            user.value = data.user;

            return true;

        } catch (error) {

            console.error(
                'Authentication check failed:',
                error
            );

            user.value = null;

            return false;

        } finally {

            loading.value = false;

        }
    };


    const logout = async () => {
        try {
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token not found.');
                return false;
            }
            const response = await fetch('/admin/logout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });
            const data = await response.json();
            if (!response.ok) {
                console.error('Logout failed:', data);
                return false;
            }
            // Clear Vue authentication state
            user.value = null;
            return true;
        } catch (error) {
            console.error('Logout error:', error);
            return false;
        }
    };
    return {
        user,
        loading,
        isAuthenticated,
        fetchUser,
        logout,
    };
}