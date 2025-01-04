mainContent.innerHTML = `
        <head>
            <link rel='stylesheet' href='../css/prescriptions.css'>
        </head>
        <h1>Drug Prescription Form</h1>
        <form id="prescriptionForm">
            <div class="container">
                <h2>Drugs</h2>
                <!-- Analgesics -->
                <div class="drug-category">
                    <input type="checkbox" id="analgesics" ${prescription?.drugs?.analgesics ? 'checked' : ''}>
                    <label for="analgesics">Analgesics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="paracet" ${prescription?.drugs?.paracet ? 'checked' : ''}><label for="paracet">Paracet</label><br>
                        <input type="checkbox" id="ibuprofen" ${prescription?.drugs?.ibuprofen ? 'checked' : ''}><label for="ibuprofen">Ibuprofen</label><br>
                        <input type="checkbox" id="diclofenac" ${prescription?.drugs?.diclofenac ? 'checked' : ''}><label for="diclofenac">Diclofenac</label><br>
                        <input type="checkbox" id="cyclopam" ${prescription?.drugs?.cyclopam ? 'checked' : ''}><label for="cyclopam">Cyclopam</label>
                    </div>
                </div>

                <!-- Antibiotics -->
                <div class="drug-category">
                    <input type="checkbox" id="antibiotics" ${prescription?.drugs?.antibiotics ? 'checked' : ''}>
                    <label for="antibiotics">Antibiotics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="amoxicillin" ${prescription?.drugs?.amoxicillin ? 'checked' : ''}><label for="amoxicillin">Amoxicillin</label><br>
                        <input type="checkbox" id="amox-clav" ${prescription?.drugs?.amox_clav ? 'checked' : ''}><label for="amox-clav">Amox-clav</label><br>
                        <input type="checkbox" id="cefuroxime" ${prescription?.drugs?.cefuroxime ? 'checked' : ''}><label for="cefuroxime">Cefuroxime</label><br>
                        <input type="checkbox" id="cefixime" ${prescription?.drugs?.cefixime ? 'checked' : ''}><label for="cefixime">Cefixime</label><br>
                        <input type="checkbox" id="azithromycin" ${prescription?.drugs?.azithromycin ? 'checked' : ''}><label for="azithromycin">Azithromycin</label><br>
                        <input type="checkbox" id="clarithromycin" ${prescription?.drugs?.clarithromycin ? 'checked' : ''}><label for="clarithromycin">Clarithromycin</label><br>
                        <input type="checkbox" id="cefazolin" ${prescription?.drugs?.cefazolin ? 'checked' : ''}><label for="cefazolin">Cefazolin</label>
                    </div>
                </div>

                <!-- Antifungals -->
                <div class="drug-category">
                    <input type="checkbox" id="antifungals" ${prescription?.drugs?.antifungals ? 'checked' : ''}>
                    <label for="antifungals">Antifungals</label>
                    <div class="drug-list">
                        <input type="checkbox" id="clotrimazole" ${prescription?.drugs?.clotrimazole ? 'checked' : ''}><label for="clotrimazole">Clotrimazole</label><br>
                        <input type="checkbox" id="fluconazole" ${prescription?.drugs?.fluconazole ? 'checked' : ''}><label for="fluconazole">Fluconazole</label>
                    </div>
                </div>

                <!-- Antihelminthics -->
                <div class="drug-category">
                    <input type="checkbox" id="antihelminthics" ${prescription?.drugs?.antihelminthics ? 'checked' : ''}>
                    <label for="antihelminthics">Antihelminthics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="albendazole" ${prescription?.drugs?.albendazole ? 'checked' : ''}><label for="albendazole">Albendazole</label><br>
                        <input type="checkbox" id="mebendazole" ${prescription?.drugs?.mebendazole ? 'checked' : ''}><label for="mebendazole">Mebendazole</label>
                    </div>
                </div>

                <!-- Antihistamines -->
                <div class="drug-category">
                    <input type="checkbox" id="antihistamines" ${prescription?.drugs?.antihistamines ? 'checked' : ''}>
                    <label for="antihistamines">Antihistamines</label>
                    <div class="drug-list">
                        <input type="checkbox" id="cetrizine" ${prescription?.drugs?.cetrizine ? 'checked' : ''}><label for="cetrizine">Cetrizine</label><br>
                        <input type="checkbox" id="chlorpheniramine" ${prescription?.drugs?.chlorpheniramine ? 'checked' : ''}><label for="chlorpheniramine">Chlorpheniramine</label><br>
                        <input type="checkbox" id="prednisone" ${prescription?.drugs?.prednisone ? 'checked' : ''}><label for="prednisone">Prednisone</label>
                    </div>
                </div>

                <!-- Antipsychotics -->
                <div class="drug-category">
                    <input type="checkbox" id="antipsychotics" ${prescription?.drugs?.antipsychotics ? 'checked' : ''}>
                    <label for="antipsychotics">Antipsychotics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="risperidone" ${prescription?.drugs?.risperidone ? 'checked' : ''}><label for="risperidone">Risperidone</label><br>
                        <input type="checkbox" id="methylphenidate" ${prescription?.drugs?.methylphenidate ? 'checked' : ''}><label for="methylphenidate">Methylphenidate</label><br>
                        <input type="checkbox" id="aripiprazole" ${prescription?.drugs?.aripiprazole ? 'checked' : ''}><label for="aripiprazole">Aripiprazole</label><br>
                        <input type="checkbox" id="fluoxetine" ${prescription?.drugs?.fluoxetine ? 'checked' : ''}><label for="fluoxetine">Fluoxetine</label><br>
                        <input type="checkbox" id="baclofen" ${prescription?.drugs?.baclofen ? 'checked' : ''}><label for="baclofen">Baclofen</label><br>
                        <input type="checkbox" id="atomoxetine" ${prescription?.drugs?.atomoxetine ? 'checked' : ''}><label for="atomoxetine">Atomoxetine</label><br>
                        <input type="checkbox" id="lorazepam" ${prescription?.drugs?.lorazepam ? 'checked' : ''}><label for="lorazepam">Lorazepam</label><br>
                        <input type="checkbox" id="buspirone" ${prescription?.drugs?.buspirone ? 'checked' : ''}><label for="buspirone">Buspirone</label><br>
                        <input type="checkbox" id="clonidine" ${prescription?.drugs?.clonidine ? 'checked' : ''}><label for="clonidine">Clonidine</label><br>
                        <input type="checkbox" id="guanfacine" ${prescription?.drugs?.guanfacine ? 'checked' : ''}><label for="guanfacine">Guanfacine</label>
                    </div>
                </div>

                <!-- Supplements -->
                <div class="drug-category">
                    <input type="checkbox" id="supplements" ${prescription?.drugs?.supplements ? 'checked' : ''}>
                    <label for="supplements">Supplements</label>
                    <div class="drug-list">
                        <input type="checkbox" id="calcium" ${prescription?.drugs?.calcium ? 'checked' : ''}><label for="calcium">Calcium</label><br>
                        <input type="checkbox" id="iron" ${prescription?.drugs?.iron ? 'checked' : ''}><label for="iron">Iron</label><br>
                        <input type="checkbox" id="multivitamins" ${prescription?.drugs?.multivitamins ? 'checked' : ''}><label for="multivitamins">Multivitamins</label><br>
                        <input type="checkbox" id="omega3" ${prescription?.drugs?.omega3 ? 'checked' : ''}><label for="omega3">Omega 3</label><br>
                        <input type="checkbox" id="abidec" ${prescription?.drugs?.abidec ? 'checked' : ''}><label for="abidec">Abidec</label><br>
                        <input type="checkbox" id="folate" ${prescription?.drugs?.folate ? 'checked' : ''}><label for="folate">Folate</label><br>
                        <input type="checkbox" id="zinc" ${prescription?.drugs?.zinc ? 'checked' : ''}><label for="zinc">Zinc</label><br>
                        <input type="checkbox" id="vitamina" ${prescription?.drugs?.vitamina ? 'checked' : ''}><label for="vitamina">Vitamin A</label>
                    </div>
                </div>

                <!-- Antiepileptics -->
                <div class="drug-category">
                    <input type="checkbox" id="antiepileptics" ${prescription?.drugs?.antiepileptics ? 'checked' : ''}>
                    <label for="antiepileptics">Antiepileptics</label>
                    <div class="drug-list">
                        <input type="checkbox" id="sodiumvalproate" ${prescription?.drugs?.sodiumvalproate ? 'checked' : ''}><label for="sodiumvalproate">Sodium Valproate</label><br>
                        <input type="checkbox" id="phenobarbital" ${prescription?.drugs?.phenobarbital ? 'checked' : ''}><label for="phenobarbital">Phenobarbital</label><br>
                        <input type="checkbox" id="phenytoin" ${prescription?.drugs?.phenytoin ? 'checked' : ''}><label for="phenytoin">Phenytoin</label><br>
                        <input type="checkbox" id="topiramate" ${prescription?.drugs?.topiramate ? 'checked' : ''}><label for="topiramate">Topiramate</label><br>
                        <input type="checkbox" id="levetiracetam" ${prescription?.drugs?.levetiracetam ? 'checked' : ''}><label for="levetiracetam">Levetiracetam</label><br>
                        <input type="checkbox" id="clobazam" ${prescription?.drugs?.clobazam ? 'checked' : ''}><label for="clobazam">Clobazam</label><br>
                        <input type="checkbox" id="lamotrigine" ${prescription?.drugs?.lamotrigine ? 'checked' : ''}><label for="lamotrigine">Lamotrigine</label><br>
                        <input type="checkbox" id="clonazepam" ${prescription?.drugs?.clonazepam ? 'checked' : ''}><label for="clonazepam">Clonazepam</label><br>
                        <input type="checkbox" id="carbamazepine" ${prescription?.drugs?.carbamazepine ? 'checked' : ''}><label for="carbamazepine">Carbamazepine</label><br>
                        <input type="checkbox" id="gabapentin" ${prescription?.drugs?.gabapentin ? 'checked' : ''}><label for="gabapentin">Gabapentin</label>
                    </div>
                </div>

                <!-- Formulation -->
                <div class="formulation">
                    <label for="formulation">Formulation</label>
                    <select id="formulation" name="formulation">
                        <option value="syrup" ${prescription?.formulation === 'syrup' ? 'selected' : ''}>Syrup</option>
                        <option value="tablet" ${prescription?.formulation === 'tablet' ? 'selected' : ''}>Tablet</option>
                        <option value="capsule" ${prescription?.formulation === 'capsule' ? 'selected' : ''}>Capsule</option>
                        <option value="drops" ${prescription?.formulation === 'drops' ? 'selected' : ''}>Drops</option>
                        <option value="sublingual" ${prescription?.formulation === 'sublingual' ? 'selected' : ''}>Sublingual</option>
                        <option value="topical" ${prescription?.formulation === 'topical' ? 'selected' : ''}>Topical</option>
                        <option value="intramuscular" ${prescription?.formulation === 'intramuscular' ? 'selected' : ''}>Intramuscular</option>
                        <option value="intravenous" ${prescription?.formulation === 'intravenous' ? 'selected' : ''}>Intravenous</option>
                        <option value="subcutaneous" ${prescription?.formulation === 'subcutaneous' ? 'selected' : ''}>Subcutaneous</option>
                        <option value="nebulizer" ${prescription?.formulation === 'nebulizer' ? 'selected' : ''}>Nebulizer</option>
                        <option value="suppository" ${prescription?.formulation === 'suppository' ? 'selected' : ''}>Suppository</option>
                        <option value="enema" ${prescription?.formulation === 'enema' ? 'selected' : ''}>Enema</option>
                        <option value="inhaler" ${prescription?.formulation === 'inhaler' ? 'selected' : ''}>Inhaler</option>
                        <option value="nasalspray" ${prescription?.formulation === 'nasalspray' ? 'selected' : ''}>Nasal Spray</option>
                    </select>
                </div>

                <!-- Frequency -->
                <div class="frequency">
                    <label for="frequency">Frequency</label>
                    <select id="frequency" name="frequency">
                        <option value="OD" ${prescription?.frequency === 'OD' ? 'selected' : ''}>OD</option>
                        <option value="BD" ${prescription?.frequency === 'BD' ? 'selected' : ''}>BD</option>
                        <option value="TDS" ${prescription?.frequency === 'TDS' ? 'selected' : ''}>TDS</option>
                        <option value="QID" ${prescription?.frequency === 'QID' ? 'selected' : ''}>QID</option>
                        <option value="Stat" ${prescription?.frequency === 'Stat' ? 'selected' : ''}>Stat</option>
                        <option value="Weekly" ${prescription?.frequency === 'Weekly' ? 'selected' : ''}>Weekly</option>
                        <option value="Monthly" ${prescription?.frequency === 'Monthly' ? 'selected' : ''}>Monthly</option>
                    </select>
                </div>

                <!-- Duration -->
                <div class="duration">
                    <label for="duration">Duration</label>
                    <input type="radio" id="stat" name="duration" value="Stat" ${prescription?.duration === 'Stat' ? 'checked' : ''}><label for="stat">Stat</label><br>
                    <input type="radio" id="days" name="duration" value="Days" ${prescription?.duration === 'Days' ? 'checked' : ''}><label for="days">Days</label><br>
                    <input type="radio" id="weeks" name="duration" value="Weeks" ${prescription?.duration === 'Weeks' ? 'checked' : ''}><label for="weeks">Weeks</label><br>
                    <input type="radio" id="months" name="duration" value="Months" ${prescription?.duration === 'Months' ? 'checked' : ''}><label for="months">Months</label><br>
                    <div id="duration-textarea" style="display:none;">
                        <textarea placeholder="Enter details here..."></textarea>
                    </div>
                </div>

                <button type="submit" id="savePrescriptionButton">Save Prescription</button>
            </div>
        </form>`;
