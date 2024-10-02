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
                                </div>
                                <button
                                    class="w-100 btn btn-success btn"
                                    type="submit"
                                >
                                    Submit
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
                                        <div class="invalid-feedback">
                                            Please enter a valid email address
                                            for shipping updates.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <audio v-if="audioUrl" :src="audioUrl" controls></audio>
        </main>
    </div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            audioUrl: "",
            formData: {
                text: "",
                voiceGender: "MALE",
                speakingRate: 1,
                audioUrl: "",
                voiceName: "",
            },
            voiceOptions: [],
            voiceGenderOptions: [
                { value: "MALE", text: "Male" },
                { value: "FEMALE", text: "Female" },
            ],

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
        };
    },
    created() {
        this.fetchVoiceOptions();
    },
    methods: {
        fetchVoiceOptions() {
            this.formData.voiceName = "";
            this.voiceOptions = this.dataVoice.filter(
                (option) => option.ssmlGender === this.formData.voiceGender
            );
        },
        async synthesizeSpeech() {
            try {
                const response = await axios.post(
                    "/speak",
                    this.formData,
                    {
                        responseType: "blob",
                    }
                );

                // Create a URL for the audio blob
                const audioBlob = new Blob([response.data], {
                    type: "audio/mpeg",
                });
                this.audioUrl = URL.createObjectURL(audioBlob);
            } catch (error) {
                console.error("Error synthesizing speech:", error);
            }
        },
    },
};
</script>
