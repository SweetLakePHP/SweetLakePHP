# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.define "sweetlake-development", primary: true do |config_dev|
        config_dev.vm.box = "f500/debian-wheezy64"

        config_dev.vm.network :private_network, ip: "192.168.30.48"
        config_dev.vm.synced_folder ".", "/vagrant", type: "nfs"

        config_dev.vm.provider :virtualbox do |vb|
            vb.name = "sweetlakephp_development"
        end

        config_dev.vm.provision :ansible do |ansible|
            ansible.inventory_path = "ansible/hosts-vagrant"
            ansible.playbook       = "ansible/provision.yml"
            ansible.limit          = "vagrant"
        end
    end


    # This box is added to test provision and deploy scripts agains a simulated "production" environment.
    # It is not needed for regular development on the sweetlakephp website.
    #
    # To use this, you need to: >ENABLE_PROD=true vagrant up
    #
    if ENV["ENABLE_PROD"] == "true"
        config.vm.define "sweetlake-simulate-production" do |config_prod|
            config_prod.vm.box = "f500/debian-wheezy64"
            config_prod.vm.network :private_network, ip: "192.168.30.49"

            # No synched folder, this is a simlation of production after all!
            config.vm.synced_folder ".", "/vagrant", disabled: true

            config_prod.vm.provider :virtualbox do |vb|
                vb.name = "sweetlakephp_production"
            end

            # Ansible is only used to create a user, the rest is done on the commandline
            # with ansible-playbook commands.
            config_prod.vm.provision :ansible do |ansible|
                ansible.inventory_path = "ansible/hosts"
                ansible.playbook       = "ansible/setup_local_production_server.yml"
                ansible.limit          = "production-test"
                ansible.raw_arguments  = "--user=vagrant"
                ansible.raw_arguments  = "--private-key=~/.vagrant.d/insecure_private_key"
                ansible.raw_arguments  = "--ask-vault-pass"
                ansible.host_key_checking  = "False"
            end
        end
    end

end
