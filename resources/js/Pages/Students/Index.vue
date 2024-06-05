<script setup>
import MagnifyingGlass from "@/Components/Icons/MagnifyingGlass.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Swal from "sweetalert2";
import { Head, Link, useForm, router, usePage } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

defineProps({
    students: {
        type: Object,
        required: true,
    },
});

const page = usePage();
let search = ref(usePage().props.search), pageNumber = ref(1);
let studentsUrl = computed(() => {
    let url = new URL(route('students.index'));
    url.searchParams.append("page", pageNumber.value);
    if (search.value) {
        url.searchParams.append("search", search.value);
    }

    return url.toString();
});

const updatedPageNumber = (link) => {
    pageNumber.value = link.url.split("=")[1];

}

watch(() => search.value, (newSearch) => {
  if (newSearch) {
    pageNumber.value = 1;
  }
});

watch(() => studentsUrl.value, (updatedStudentsUrl) => {
    router.visit(updatedStudentsUrl, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
 })

const deleteForm = useForm({});

const deleteStudent = (id) => {
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
            deleteForm.delete(route('students.destroy', id), {
                onFinish: () => {
                    Swal.fire("Excluído!", "O estudante foi excluído.", "success");
                }
            });
        }
    });
};

</script>

<template>
    <Head title="Gerenciamento de Estudantes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listagem de Alunos
            </h2>
        </template>
        <div class="bg-gray-100 py-10">
            <div class="mx-auto max-w-7xl">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <p class="mt-2 text-sm text-gray-700">
                                Uma lista de todos os alunos.
                            </p>
                        </div>

                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <Link
                                v-if="page.props.can.criar_alunos"
                                :href="route('students.create')"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                            >
                                Adicionar Aluno
                            </Link>
                        </div>
                    </div>

                    <div class="flex flex-col justify-between sm:flex-row mt-6">
                        <div class="relative text-sm text-gray-800 col-span-3">
                            <div
                                class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500"
                            >
                                <MagnifyingGlass />
                            </div>

                            <input
                                v-model="search"
                                type="text"
                                autocomplete="off"
                                placeholder="Procurar dados de estudante..."
                                id="search"
                                class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
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
                                                    Nome
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    E-mail
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Classe
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Seção
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Criado em
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                                                />
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                            <tr
                                                v-if="page.props.can.enxergar_alunos"
                                                v-for="student in students.data"
                                                :key="student.id"
                                            >
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ student.id }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ student.name }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ student.email }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ student.class.name }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ student.section.name }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ student.created_at }}
                                                </td>

                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                                >
                                                    <Link
                                                        :disabled="!page.props.can.editar_alunos"
                                                        :href="page.props.can.editar_alunos ? route('students.edit', student.id) : '#'"
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                        :class="{'ml-2 text-indigo-200 hover:text-indigo-300 cursor-not-allowed' : !page.props.can.editar_alunos}"
                                                    >
                                                        Editar
                                                    </Link>
                                                    <button
                                                        :disabled="!page.props.can.apagar_alunos"
                                                        @click="deleteStudent(student.id)"
                                                        class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                        :class="{'ml-2 text-indigo-200 hover:text-indigo-300 cursor-not-allowed' : !page.props.can.apagar_alunos}"
                                                    >
                                                        Apagar
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Pagination v-if="page.props.can.enxergar_alunos" :data="students" :updatedPageNumber="updatedPageNumber" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
