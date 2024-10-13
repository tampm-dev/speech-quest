<template>
    <div class="container">
        <main>
            <div class="py-5 text-center">
                <h2 class="mb-5">Speech Quest</h2>
                <p>
                    A journey of developing and perfecting voice technology,
                    from converting text to audio to realistically simulating
                    human speech, including lip movements and expressions.
                </p>
                <p>
                    A mission to enhance virtual communication experiences,
                    making TTS technology more lifelike and interactive.
                </p>
            </div>
            <form
                @submit.prevent="synthesizeSpeech"
                class="needs-validation"
                novalidate
            >
                <div class="row g-5">
                    <div class="col-md-5 col-lg-4 order-md-last">
                        <h5
                            class="d-flex justify-content-between align-items-center mb-3"
                        >
                            <span>Get code</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12 mb-3">
                                        <label
                                            for="customRange1"
                                            class="form-label"
                                            >Voice gender</label
                                        >
                                        <select
                                            class="form-select form-select-sm"
                                            aria-label="Default select example"
                                            v-model="formData.voiceGender"
                                            @change="fetchVoiceOptions"
                                        >
                                            <option
                                                v-for="option in voiceGenderOptions"
                                                :key="option.value"
                                                :value="option.value"
                                            >
                                                {{ option.text }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label
                                            for="voiceName"
                                            class="form-label"
                                            >Voice name</label
                                        >
                                        <select
                                            class="form-select form-select-sm"
                                            aria-label="Default select example"
                                            v-model="formData.voiceName"
                                        >
                                            <option disabled value="">
                                                Select a voice name
                                            </option>
                                            <option
                                                v-for="option in voiceOptions"
                                                :key="option.name"
                                                :value="option.name"
                                            >
                                                {{ option.name }}
                                            </option>
                                        </select>
                                        <small
                                            v-if="errors && errors.voiceName"
                                            class="text-danger mt-2"
                                        >
                                            {{ errors.voiceName[0] }}
                                        </small>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label
                                            for="speakingRate"
                                            class="form-label"
                                            >Speed</label
                                        >
                                        <input
                                            type="range"
                                            class="form-range"
                                            id="speakingRate"
                                            min="0.25"
                                            max="4"
                                            step="0.5"
                                            v-model="formData.speakingRate"
                                        />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label
                                            for="fileInput"
                                            class="form-label"
                                            >Upload Image</label
                                        >
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="fileInput"
                                            accept="image/*"
                                            @change="onImageChange"
                                        />
                                        <small
                                            v-if="errors && errors.image"
                                            class="text-danger mt-2"
                                        >
                                            {{ errors.image[0] }}
                                        </small>
                                    </div>
                                </div>
                                <button
                                    class="w-100 btn btn-success btn"
                                    type="submit"
                                    v-if="!isLoading"
                                >
                                    Submit
                                </button>
                                <button
                                    class="w-100 btn btn-success btn"
                                    type="submit"
                                    v-else
                                >
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-8">
                        <h5
                            class="d-flex justify-content-between align-items-center mb-3"
                        >
                            <span>Text to speech</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="text" class="form-label"
                                            >Text
                                        </label>
                                        <textarea
                                            type="text"
                                            class="form-control"
                                            id="text"
                                            rows="5"
                                            placeholder="Write your text here..."
                                            v-model="formData.text"
                                        ></textarea>
                                        <small
                                            v-if="errors && errors.text"
                                            class="text-danger mt-2"
                                        >
                                            {{ errors.text[0] }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <video v-if="resultUrl" width="600" controls>
                <source :src="resultUrl" type="video/mp4" />
                Your browser does not support the video tag.
            </video>
        </main>
    </div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            resultUrl: "",
            formData: {
                text: "",
                voiceGender: "MALE",
                speakingRate: 1,
                voiceName: "",
            },
            selectedImage: null,
            voiceOptions: [],
            voiceGenderOptions: [
                { value: "MALE", text: "Male" },
                { value: "FEMALE", text: "Female" },
            ],
            isLoading: false,
            // Instead of get API
            dataVoice: [
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Neural2-A",
                    ssmlGender: "FEMALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Neural2-D",
                    ssmlGender: "MALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Standard-A",
                    ssmlGender: "FEMALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Standard-B",
                    ssmlGender: "MALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Standard-C",
                    ssmlGender: "FEMALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Standard-D",
                    ssmlGender: "MALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Wavenet-A",
                    ssmlGender: "FEMALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Wavenet-B",
                    ssmlGender: "MALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Wavenet-C",
                    ssmlGender: "FEMALE",
                    naturalSampleRateHertz: 24000,
                },
                {
                    languageCodes: ["vi-VN"],
                    name: "vi-VN-Wavenet-D",
                    ssmlGender: "MALE",
                    naturalSampleRateHertz: 24000,
                },
            ],
            errors: null,
        };
    },
    created() {
        this.fetchVoiceOptions();
    },
    methods: {
        onImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.selectedImage = file;
            }
        },
        fetchVoiceOptions() {
            this.formData.voiceName = "";
            this.voiceOptions = this.dataVoice.filter(
                (option) => option.ssmlGender === this.formData.voiceGender
            );
        },

        async synthesizeSpeech() {
            this.isLoading = true;
            const formData = new FormData();
            formData.append("text", this.formData.text);
            formData.append("languageCode", "vi-VN");
            formData.append("voiceGender", "MALE");
            formData.append("speakingRate", this.formData.speakingRate);
            formData.append("voiceName", this.formData.voiceName);
            if (this.selectedImage) {
                formData.append("image", this.selectedImage);
            }
            try {
                const response = await axios.post("/generate", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                this.resultUrl = response?.data?.result_url;
                this.isLoading = false;
            } catch (error) {
                this.isLoading = false;
                this.errors = error?.response?.data?.errors;
            }
        },

        async getTalks() {
            try {
                const response = await axios.get("/get-talks");
            } catch (error) {
                console.error("Error synthesizing speech:", error);
            }
        },
    },
};
</script>
