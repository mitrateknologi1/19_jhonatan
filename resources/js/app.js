import "choices.js/public/assets/styles/choices.min.css";
import Choices from "choices.js";
import Swal from "sweetalert2";
import Chart from "chart.js/auto";
import axios from "axios";

const base_url = import.meta.env.VITE_APP_URL;

document.addEventListener("DOMContentLoaded", () => {
    const flashMsgError = document.getElementById("flash-message-error");
    const flashMsgMessage = document.getElementById("flash-message-message");

    if (flashMsgError && flashMsgMessage) {
        Swal.fire({
            icon: flashMsgError.value ? "error" : "success",
            title: flashMsgError.value ? "error" : "success",
            text: flashMsgMessage.value,
            showConfirmButton: false,
            timer: 1500,
        });
    }
});

const selectCustomer = () => ({
    init() {
        const choices = new Choices(this.$refs.selectEl, {
            classNames: {
                containerOuter: "choices !mb-0 !w-full join-item",
                containerInner:
                    "choices__inner !text-base !min-h-12 !max-h-12 !rounded-md",
            },
        });

        const inputEl = this.$refs.inputEl;

        this.$refs.selectEl.addEventListener("choice", (e) => {
            if (this.currVal != e.detail.choice.value) {
                inputEl.value = e.detail.choice.value;
                inputEl.dispatchEvent(new Event("input"));
                this.currVal = e.detail.choice.value;
            }
        });
    },
});

const selectPriodeBulan = () => ({
    init() {
        const choices = new Choices(this.$el, {
            classNames: {
                containerOuter: "choices !mb-0 !w-full join-item",
                containerInner:
                    "choices__inner !text-base !min-h-12 !max-h-12 !rounded-md",
            },
        });
    },
});

const confirmDeleteModal = () => ({
    async showModal() {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        });

        if (result.isConfirmed) {
            this.$root.submit();
        }
    },
});

const formatMonthsToNames = (monthNumbers) => {
    const monthNames = [];

    monthNumbers.forEach((monthNumber) => {
        const date = new Date(2000, monthNumber - 1, 1); // Month is 0-indexed in JavaScript Date object
        const monthName = date.toLocaleString("default", { month: "long" });
        monthNames.push(monthName);
    });

    return monthNames;
};

const chartPenjualanTahunan = () => ({
    async init() {
        const res = await axios({
            method: "get",
            url: `${base_url}/dashboard/data/chart`,
            responseType: "json",
        });

        const dataChart = res.data.data ?? [];

        const data = {
            labels: formatMonthsToNames(dataChart.map((item) => item.month)),
            datasets: [
                {
                    label: "Dataset",
                    data: dataChart.map((item) => item.total),
                    pointStyle: "circle",
                    pointRadius: 10,
                    pointHoverRadius: 15,
                },
            ],
        };

        const chart = new Chart(this.$refs.canvas, {
            type: "line",
            data: data,
        });
    },
});

document.addEventListener("alpine:init", () => {
    Alpine.data("select_customer", selectCustomer);
    Alpine.data("select_priode_bulan", selectPriodeBulan);
    Alpine.data("confirm_delete_modal", confirmDeleteModal);
    Alpine.data("chart_penjualan_tahunan", chartPenjualanTahunan);
});
