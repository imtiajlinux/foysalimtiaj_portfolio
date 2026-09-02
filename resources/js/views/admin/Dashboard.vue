<template>

    <AdminLayout>

        <!-- Page Header -->

        <div class="dashboard-header">

            <div>
                <h4>Dashboard</h4>

                <p>
                    Manage your portfolio from here.
                </p>
            </div>

            <button class="btn btn-dark">
                <i class="bi bi-plus-lg me-2"></i>
                Add Project
            </button>

        </div>


        <!-- Statistics -->

        <div class="row g-4 mb-4">

            <div
                v-for="stat in statistics"
                :key="stat.title"
                class="col-xl-3 col-md-6"
            >

                <div class="stat-card">

                    <div class="stat-content">

                        <span>
                            {{ stat.title }}
                        </span>

                        <h3>
                            {{ stat.value }}
                        </h3>

                        <small>
                            {{ stat.description }}
                        </small>

                    </div>

                    <div class="stat-icon">
                        <i :class="stat.icon"></i>
                    </div>

                </div>

            </div>

        </div>


        <!-- Content -->

        <div class="row g-4">

            <!-- Recent Projects -->

            <div class="col-lg-8">

                <div class="content-card">

                    <div class="card-header-custom">

                        <div>
                            <h6>Recent Projects</h6>
                            <span>Your latest portfolio projects</span>
                        </div>

                        <router-link
                            to="/admin/projects"
                            class="view-all"
                        >
                            View All
                        </router-link>

                    </div>


                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>

                                <tr>
                                    <th>Project</th>
                                    <th>Technology</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>

                            </thead>

                            <tbody>

                                <tr
                                    v-for="project in projects"
                                    :key="project.name"
                                >

                                    <td>

                                        <div class="project-name">

                                            <div class="project-image">
                                                {{ project.name.charAt(0) }}
                                            </div>

                                            <strong>
                                                {{ project.name }}
                                            </strong>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="technology">
                                            {{ project.technology }}
                                        </span>
                                    </td>

                                    <td>

                                        <span
                                            class="status"
                                            :class="project.statusClass"
                                        >
                                            {{ project.status }}
                                        </span>

                                    </td>

                                    <td>
                                        {{ project.date }}
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- Quick Actions -->

            <div class="col-lg-4">

                <div class="content-card">

                    <div class="card-header-custom">

                        <div>
                            <h6>Quick Actions</h6>
                            <span>Common management tasks</span>
                        </div>

                    </div>


                    <div class="quick-actions">

                        <router-link
                            to="/admin/projects/create"
                            class="quick-action"
                        >

                            <div class="quick-icon">
                                <i class="bi bi-folder-plus"></i>
                            </div>

                            <div>
                                <strong>
                                    Add Project
                                </strong>

                                <span>
                                    Create portfolio project
                                </span>
                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </router-link>


                        <router-link
                            to="/admin/skills"
                            class="quick-action"
                        >

                            <div class="quick-icon">
                                <i class="bi bi-lightning-charge"></i>
                            </div>

                            <div>
                                <strong>
                                    Manage Skills
                                </strong>

                                <span>
                                    Update your technologies
                                </span>
                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </router-link>


                        <router-link
                            to="/admin/messages"
                            class="quick-action"
                        >

                            <div class="quick-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            <div>
                                <strong>
                                    Messages
                                </strong>

                                <span>
                                    Check contact messages
                                </span>
                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </router-link>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>


<script setup>

import AdminLayout from '../../layouts/AdminLayout.vue';


const statistics = [

    {
        title: 'Projects',
        value: '24',
        description: 'Total portfolio projects',
        icon: 'bi bi-folder2-open'
    },

    {
        title: 'Skills',
        value: '18',
        description: 'Technologies & skills',
        icon: 'bi bi-lightning'
    },

    {
        title: 'Messages',
        value: '12',
        description: 'Total contact messages',
        icon: 'bi bi-envelope'
    },

    {
        title: 'Experience',
        value: '05',
        description: 'Work experiences',
        icon: 'bi bi-briefcase'
    }

];


const projects = [

    {
        name: 'Portfolio Website',
        technology: 'Laravel + Vue',
        status: 'Published',
        statusClass: 'published',
        date: 'Aug 28, 2026'
    },

    {
        name: 'POS Management',
        technology: 'Laravel',
        status: 'Published',
        statusClass: 'published',
        date: 'Aug 20, 2026'
    },

    {
        name: 'E-commerce System',
        technology: 'Vue + Laravel',
        status: 'Draft',
        statusClass: 'draft',
        date: 'Aug 15, 2026'
    }

];

</script>


<style scoped>

.dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 25px;
}

.dashboard-header h4 {
    margin: 0;

    font-size: 22px;

    font-weight: 700;

    color: #202733;
}

.dashboard-header p {
    margin: 5px 0 0;

    font-size: 13px;

    color: #8991a0;
}


/* Statistics */

.stat-card {
    background: #ffffff;

    border: 1px solid #e9edf3;

    border-radius: 12px;

    padding: 22px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    transition: 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);

    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
}

.stat-content span {
    font-size: 12px;

    color: #8c94a3;
}

.stat-content h3 {
    margin: 7px 0;

    font-size: 25px;

    font-weight: 700;

    color: #202733;
}

.stat-content small {
    font-size: 10px;

    color: #a0a7b3;
}

.stat-icon {
    width: 46px;
    height: 46px;

    border-radius: 10px;

    background: #f1f3f5;

    color: #343a40;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 19px;
}


/* Card */

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

.view-all {
    font-size: 11px;

    color: #495057;

    text-decoration: none;

    font-weight: 600;
}


/* Table */

.table thead th {
    background: #fafbfc;

    border-bottom: 1px solid #edf0f4;

    color: #9299a6;

    font-size: 10px;

    font-weight: 600;

    text-transform: uppercase;
}

.table tbody td {
    border-color: #f0f2f5;

    color: #697386;

    font-size: 12px;
}

.project-name {
    display: flex;
    align-items: center;

    gap: 10px;
}

.project-image {
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
}

.project-name strong {
    font-size: 12px;

    color: #343a40;
}

.technology {
    font-size: 11px;

    background: #f5f6f8;

    padding: 5px 8px;

    border-radius: 5px;
}

.status {
    font-size: 10px;

    padding: 5px 8px;

    border-radius: 20px;

    font-weight: 600;
}

.status.published {
    background: #e9f7ef;
    color: #198754;
}

.status.draft {
    background: #fff4e5;
    color: #fd7e14;
}


/* Quick Actions */

.quick-actions {
    padding: 8px 15px 15px;
}

.quick-action {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 13px 5px;

    border-bottom: 1px solid #f0f2f5;

    text-decoration: none;

    color: inherit;
}

.quick-action:last-child {
    border-bottom: 0;
}

.quick-icon {
    width: 38px;
    height: 38px;

    border-radius: 8px;

    background: #f1f3f5;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #495057;
}

.quick-action div:nth-child(2) {
    flex: 1;
}

.quick-action strong {
    display: block;

    font-size: 12px;

    color: #343a40;
}

.quick-action span {
    font-size: 10px;

    color: #9299a6;
}

.quick-action > i {
    font-size: 11px;

    color: #adb5bd;
}

</style>