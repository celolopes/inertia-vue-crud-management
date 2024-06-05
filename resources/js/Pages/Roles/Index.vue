<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Swal from "sweetalert2";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
    roles: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const deleteForm = useForm({});

const deleteRole = (id) => {
    Swal.fire({
        title: "Você tem certeza?",
        text: "Você não poderá reverter esta ação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            deleteForm.delete(route('roles.destroy', id), {
                onFinish: () => {
                    Swal.fire("Excluída!", "A regra foi excluída.", "success");
                }
            });
        }
    });
};

</script>

<template>
    <Head title="Gerenciamento de Regras" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listagem de Regras
            </h2>
        </template>
        <div class="bg-gray-100 py-10">
            <div class="mx-auto max-w-7xl">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <p class="mt-2 text-sm text-gray-700">
                                Uma lista de todas as regras do sistema de gerenciamento de alunos.
                            </p>
                        </div>

                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <Link
                                v-if="page.props.can.criar_regras"
                                :href="route('roles.create')"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                            >
                                Adicionar Regra
                            </Link>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col">
                        <div
                            class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8"
                        >
                            <div
                                class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                            >
                                <div
                                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative"
                                >
                                    <table
                                        class="min-w-full divide-y divide-gray-300"
                                    >
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    ID
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    Descrição
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                            <tr
                                                v-if="page.props.can.enxergar_regras"
                                                v-for="role in roles.data"
                                                :key="role.id"
                                            >
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ role.id }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ role.title }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ role.created_at }}
                                                </td>

                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                                >
                                                    <Link
                                                        :disabled="!page.props.can.editar_regras"
                                                        :href="page.props.can.editar_regras ? route('roles.edit', role.id) : '#'"
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                        :class="{'text-indigo-200 hover:text-indigo-300 cursor-not-allowed' : !page.props.can.editar_regras}"
                                                    >
                                                        Editar
                                                    </Link>
                                                    <button
                                                        :disabled="!page.props.can.apagar_regras"
                                                        @click="deleteRole(role.id)"
                                                        class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                        :class="{'text-indigo-200 hover:text-indigo-300 cursor-not-allowed' : !page.props.can.apagar_regras}"
                                                    >
                                                        Apagar
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
